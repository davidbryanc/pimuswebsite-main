<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    
    public function accounts()
    {
        $accounts = DB::table('users')->orderBy('divisi')->orderBy('nrp')->get();

        $countAccount = DB::table('users')->count();

        $countTicket = DB::table('users')->select(DB::raw('SUM(tiket_vote) as count_ticket'))->get();

        return view('admin.accounts', ['arrAccounts' => $accounts, 'countAccount' => $countAccount, 'countTicket'=>$countTicket]);
    }

    public function groups()
    {
        // get group data
        $groups = DB::table('kelompok')
                    ->join('cabang_lomba', 'kelompok.idlomba', '=', 'cabang_lomba.idlomba')
                    ->select('kelompok.*', DB::raw('cabang_lomba.nama as nama_cabang'))
                    ->orderBy('nama_cabang')
                    ->get();

        // get all users data
        $detail_users = DB::table('users')
                        ->join('detail_user', 'users.nrp', '=', 'detail_user.nrp')
                        ->select(DB::raw('users.nama as nama_user'), 'users.email', 'detail_user.*')
                        ->orderBy('detail_user.role', 'desc')
                        ->get();

        // get all submissions
        $submissions = DB::table('kelompok')
                        ->join('pengumpulan', 'kelompok.idkelompok', '=', 'pengumpulan.idkelompok')
                        ->select('kelompok.idkelompok', 'pengumpulan.*')
                        ->get();

        return view('admin.groups', ['arrGroups'=>$groups, 'arrDetailUsers'=>$detail_users, 'arrSubmissions'=>$submissions]);
    }

    public function editUser()
    {
        date_default_timezone_set('Asia/Jakarta');

        $nrp = $_POST['nrp'];
        $divisi = $_POST['updateDivisi'];

        if ($_POST['updateVerification'] == 1) {
            $verified = DB::table('users')
                            ->select('email_verified_at')
                            ->where('nrp', '=', $nrp)
                            ->get();

            foreach ($verified as $alreadyVerified) {
                if ($alreadyVerified->email_verified_at != null)
                    $verification = $alreadyVerified->email_verified_at;
                else
                    $verification = date("y-m-j H:m:s");
            }
        }
        else
            $verification = null;  

        DB::table('users')->where('nrp', '=', $nrp)
            ->update(['divisi'=>$divisi, 'email_verified_at'=>$verification]);
        
        return redirect()->route('admin.accounts');
    }
    
    public function editGroup()
    {
        $idkelompok = $_POST['idkelompok'];
        $status = $_POST['updateStatus'];

        if ($status == "Tolak")
            $message = $_POST['detailMessage'];
        else
            $message = "";
        
        DB::table('kelompok')->where('idkelompok', '=', $idkelompok)
            ->update(['status'=>$status, 'pesan'=>$message]);
        
        return redirect()->route('admin.groups');
    }

    public function deleteUser()
    {
        $nrp = $_POST['nrp'];
        
        $idkelompok = DB::table('detail_user')
                        ->select('idkelompok')
                        ->where('nrp', '=', $nrp)
                        ->where('role', '=', 'Ketua')
                        ->get();

        DB::table('detail_user')->where('nrp', '=', $nrp)->delete();
        
        foreach($idkelompok as $id) {
            DB::table('pengumpulan')->where('idkelompok', '=', $id->idkelompok)->delete();
            DB::table('kelompok')->where('idkelompok', '=', $id->idkelompok)->delete();
        }
        
        DB::table('users')->where('nrp', '=', $nrp)->delete();

        return redirect()->route('admin.accounts');
    }

    public function specialCase()
    {
        $contest = DB::table('cabang_lomba')->get();

        $contestants = DB::table('users')
                        ->select('nrp', 'nama')
                        ->where('divisi', '=', 'Umum')
                        ->get();

        return view('admin.specialCase', ['contest'=>$contest, 'contestants'=>$contestants]);
    }
    
    public function addGroup(Request $request)
    {
        // Generate idkelompok where is Empty
        $idGroup = 1;
        $group = DB::table('kelompok')->where('idkelompok', '=', $idGroup)->get();

        while (!$group->isEmpty()) {
            $idGroup++;
            $group = DB::table('kelompok')->where('idkelompok', '=', $idGroup)->get();
        }

        $idContest = $request->contest;

        // Insert Data to kelompok table
        DB::table('kelompok')->insert([
            'idkelompok' => $idGroup,
            'idlomba' => $idContest,
            'formulir_pendaftaran' => "empty",
            'surat_pernyataan' => "empty",
            'status' => 'Pending'
        ]);

        // Insert data to detail_user table
            // Ketua||Peserta
            $nrp = $request->nrpKetua;

            $checkNRP =  DB::table('users')
                            ->select('nrp', 'nama')
                            ->where('nrp', '=', $nrp)
                            ->get();

            if ($checkNRP->isEmpty())
                return redirect()->route('admin.groups', ['messageType'=>'error', 'message'=>"NRP yang diinputkan salah, Silakan coba lagi"]);

            DB::table('detail_user')->insert([
                'nrp' => $nrp,
                'idkelompok' => $idGroup,
                'role' => "Ketua",
                'ktm' => "empty",
                'pas_foto' => "empty"
            ]);

            // Anggota
            if (isset($request->nrpAnggota)) {
                $memberAmount = $request->jumlahAnggota;

                for ($i=0; $i < $memberAmount-1; $i++) { 
                    $nrp = $request->nrpAnggota[$i];

                    $checkNRP =  DB::table('users')
                            ->select('nrp', 'nama')
                            ->where('nrp', '=', $nrp)
                            ->get();

                    if ($checkNRP->isEmpty())
                        return redirect()->route('admin.groups', ['messageType'=>'error', 'message'=>"NRP yang diinputkan salah, Silakan coba lagi"]);
    
                    DB::table('detail_user')->insert([
                        'nrp' => $nrp,
                        'idkelompok' => $idGroup,
                        'role' => "Anggota",
                        'ktm' => "empty",
                        'pas_foto' => "empty"
                    ]);
                }
            }

            return redirect()->route('admin.groups', ['messageType'=>'success', 'message'=>"Kelompok berhasil dibuat"]);
    }

    public function submissions()
    {
        $submissions = DB::table('pengumpulan')
                        ->orderBy('idlomba')
                        ->orderBy('like_count', 'desc')
                        ->get();

        $leaders = DB::table('users')
                    ->join('detail_user', 'users.nrp', '=', 'detail_user.nrp')
                    ->select('users.nama', 'detail_user.idkelompok')
                    ->where('detail_user.role', '=', 'Ketua')
                    ->get();

        $contests = DB::table('cabang_lomba')->get();

        $countLike = DB::table('pengumpulan')->select(DB::raw('SUM(like_count) as count_like'))->get();

        return view('admin.submissions', ['submissions'=>$submissions, 'leaders'=>$leaders, 'contests'=>$contests, 'countLike'=>$countLike]);
    }

    public function updateSubmissions(Request $request)
    {
        $id = $request->id;
        $idContest = $request->updateContest;
        $name = $request->updateName;
        $description = $request->updateDescription;
        $linkDrive = $request->updateLinkDrive;
        $linkPosterYoutube = $request->updateLinkPosterYoutube;

        if ($id != null && $idContest != null && $name != null && $description != null && $linkDrive != null && $linkPosterYoutube != null) {
            DB::table('pengumpulan')
                ->where('id', '=', $id)
                ->update(['idlomba'=>$idContest, 'nama'=>$name, 'deskripsi'=>$description, 'link_drive'=>$linkDrive, 'link_poster_youtube'=>$linkPosterYoutube]);

            return redirect()->route('admin.submissions', ['messageType'=>"success", 'message'=>"Data pengumpulan atas nama $name berhasil diubah"]);
        }
        else
            return redirect()->route('admin.submissions', ['messageType'=>"error", 'message'=>"Terjadi kesalahan dalam update, mohon cek kembali pengisian dan coba lagi"]);
    }

    public function deleteSubmissions(Request $request)
    {
        $id = $request->id;

        if ($id != null) {
            DB::table('pengumpulan')
                ->where('id', '=', $id)
                ->delete();

            return redirect()->route('admin.submissions', ['messageType'=>"success", 'message'=>"Data pengumpulan berhasil dihapus"]);
        }
        else
            return redirect()->route('admin.submissions', ['messageType'=>"error", 'message'=>"Terjadi kesalahan dalam proses penghapusan, silakan coba lagi"]);
    }

    public function addSubmission(Request $request)
    {
        $idContest = $request->addContest;
        $name = $request->addName;
        $description = $request->addDescription;
        $linkDrive = $request->addLinkDrive;
        $linkPosterYoutube = $request->addLinkPosterYoutube;

        if ($idContest != null && $name != null && $description != null && $linkDrive != null && $linkPosterYoutube != null) {
            $id = 0;

            do {
                $id++;

                $submissions = DB::table('pengumpulan')
                                ->where('id', '=', $id)
                                ->get();
            } while ($submissions->isNotEmpty());

            DB::table('pengumpulan')->insert([
                'id' => $id,
                'idlomba' => $idContest,
                'nama' => $name,
                'deskripsi' => $description,
                'link_drive' => $linkDrive,
                'like_count' => 0,
                'link_poster_youtube' => $linkPosterYoutube
            ]);

            return redirect()->route('admin.submissions', ['messageType'=>"success", 'message'=>"Data pengumpulan atas nama $name berhasil ditambahkan"]);
        }
        else
            return redirect()->route('admin.submissions', ['messageType'=>"error", 'message'=>"Terjadi kesalan dalam penambahan data, mohon cek kembali dan coba lagi"]);
    }
}