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
        $accounts = DB::table('users')->orderBy('role')->orderBy('nrp')->get();

        $countAccount = DB::table('users')->count();

        $countTicket = DB::table('users')->select(DB::raw('SUM(vote_tickets) as count_ticket'))->get();

        return view('admin.accounts', ['arrAccounts' => $accounts, 'countAccount' => $countAccount, 'countTicket'=>$countTicket]);
    }

    public function groups()
    {
        // get group data
        $groups = DB::table('teams')
                    ->join('competition_categories', 'teams.competition_categories_id', '=', 'competition_categories.id')
                    ->select('teams.*', DB::raw('competition_categories.name as nama_cabang') , DB::raw('competition_categories.competition_type'))
                    ->orderBy('nama_cabang')
                    ->get();

        // get all users data
        $detail_users = DB::table('users')
                        ->join('user_details', 'users.nrp', '=', 'user_details.nrp')
                        ->select(DB::raw('users.name as nama_user'), 'users.email', 'user_details.*')
                        ->orderBy('user_details.role', 'desc')
                        ->get();

        // get all submissions
        $submissions = DB::table('teams')
                        ->join('submissions', 'teams.id', '=', 'submissions.teams_id')
                        ->select('teams.id', 'submissions.*')
                        ->get();

        // dd($groups);                

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
            ->update(['role'=>$divisi, 'email_verified_at'=>$verification]);
        
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
        
        DB::table('teams')->where('id', '=', $idkelompok)
            ->update(['status'=>$status, 'message'=>$message]);
        
        return redirect()->route('admin.groups');
    }

    public function deleteUser()
    {
        $nrp = $_POST['nrp'];
        
        $idkelompok = DB::table('user_details')
                        ->select('teams_id')
                        ->where('nrp', '=', $nrp)
                        ->where('role', '=', 'Ketua')
                        ->get();

        DB::table('user_details')->where('nrp', '=', $nrp)->delete();
        
        foreach($idkelompok as $id) {
            DB::table('submissions')->where('teams_id', '=', $id->idkelompok)->delete();
            DB::table('teams')->where('id', '=', $id->idkelompok)->delete();
        }
        
        DB::table('users')->where('nrp', '=', $nrp)->delete();

        return redirect()->route('admin.accounts');
    }

    public function specialCase()
    {
        $contest = DB::table('competition_categories')->get();

        $contestants = DB::table('users')
                        ->select('nrp', 'name')
                        ->where('role', '=', 'Umum')
                        ->get();

        return view('admin.specialCase', ['contest'=>$contest, 'contestants'=>$contestants]);
    }
    
    public function addGroup(Request $request)
    {
        // Generate idkelompok where is Empty
        $idGroup = 1;
        $group = DB::table('teams')->where('id', '=', $idGroup)->get();

        while (!$group->isEmpty()) {
            $idGroup++;
            $group = DB::table('teams')->where('id', '=', $idGroup)->get();
        }

        $idContest = $request->contest;

        // Insert Data to kelompok table
        DB::table('teams')->insert([
            'id' => $idGroup,
            'competition_categories_id' => $idContest,
            'registration_form' => "empty",
            'statement_letter' => "empty",
            'status' => 'Pending'
        ]);

        // Insert data to detail_user table
            // Ketua||Peserta
            $nrp = $request->nrpKetua;

            $checkNRP =  DB::table('users')
                            ->select('nrp', 'name')
                            ->where('nrp', '=', $nrp)
                            ->get();

            if ($checkNRP->isEmpty())
                return redirect()->route('admin.groups', ['messageType'=>'error', 'message'=>"NRP yang diinputkan salah, Silakan coba lagi"]);

            DB::table('user_details')->insert([
                'nrp' => $nrp,
                'teams_id' => $idGroup,
                'role' => "Ketua",
                'id_card' => "empty",
                'self_photo' => "empty"
            ]);

            // Anggota
            if (isset($request->nrpAnggota)) {
                $memberAmount = $request->jumlahAnggota;

                for ($i=0; $i < $memberAmount-1; $i++) { 
                    $nrp = $request->nrpAnggota[$i];

                    $checkNRP =  DB::table('users')
                            ->select('nrp', 'name')
                            ->where('nrp', '=', $nrp)
                            ->get();

                    if ($checkNRP->isEmpty())
                        return redirect()->route('admin.groups', ['messageType'=>'error', 'message'=>"NRP yang diinputkan salah, Silakan coba lagi"]);
    
                    DB::table('user_details')->insert([
                        'nrp' => $nrp,
                        'teams_id' => $idGroup,
                        'role' => "Anggota",
                        'id_card' => "empty",
                        'self_photo' => "empty"
                    ]);
                }
            }

            return redirect()->route('admin.groups', ['messageType'=>'success', 'message'=>"Kelompok berhasil dibuat"]);
    }

    public function submissions()
    {
        $submissions = DB::table('submissions')
                        ->orderBy('competition_categories_id')
                        ->orderBy('like_count', 'desc')
                        ->get();
        // dd($submissions);

        $leaders = DB::table('users')
                    ->join('user_details', 'users.nrp', '=', 'user_details.nrp')
                    ->select('users.name', 'user_details.teams_id')
                    ->where('user_details.role', '=', 'Ketua')
                    ->get();

        $contests = DB::table('competition_categories')->get();

        $countLike = DB::table('submissions')->select(DB::raw('SUM(like_count) as count_like'))->get();

        return view('admin.submissions', ['submissions'=>$submissions, 'leaders'=>$leaders, 'contests'=>$contests, 'countLike'=>$countLike]);
    }

    public function updateSubmissions(Request $request)
    {
        $id = $request->id;
        $idContest = $request->updateContest;
        $name = $request->updateName;
        $description = $request->updateDescription;
        $linkExhibition = $request->updateLinkExhibition;
        $linkProposal = $request->updateLinkProposal;

        if ($id != null && $idContest != null && $description != null) {
            DB::table('submissions')
                ->where('id', '=', $id)
                ->update(
                    ['competition_categories_id'=>$idContest, 
                    'description'=>$description, 
                    'link_exhibition'=>$linkExhibition, 
                    'link_proposal'=>$linkProposal]);

            return redirect()->route('admin.submissions', ['messageType'=>"success", 'message'=>"Data pengumpulan atas nama $name berhasil diubah"]);
        }
        else
            return redirect()->route('admin.submissions', ['messageType'=>"error", 'message'=>"Terjadi kesalahan dalam update, mohon cek kembali pengisian dan coba lagi"]);
    }

    public function deleteSubmissions(Request $request)
    {
        $id = $request->id;

        if ($id != null) {
            DB::table('submissions')
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
        $teams_id = $request->addTeam;
        $description = $request->addDescription;
        $linkExhib = $request->addLinkExhib;
        $linkProposal = $request->addLinkProposal;

        if ($idContest != null && $teams_id != null && $linkProposal != null) {
            $id = 0;

            do {
                $id++;

                $submissions = DB::table('submissions')
                                ->where('id', '=', $id)
                                ->get();
            } while ($submissions->isNotEmpty());

            DB::table('submissions')->insert([
                'id' => $id,
                'teams_id' => $teams_id,
                'competition_categories_id' => $idContest,
                'link_exhibition' => $linkExhib,
                'link_proposal' => $linkProposal,
                'description' => $description,
                'like_count' => 0
            ]);

            return redirect()->route('admin.submissions', ['messageType'=>"success", 'message'=>"Data pengumpulan berhasil ditambahkan"]);
        }
        else
            return redirect()->route('admin.submissions', ['messageType'=>"error", 'message'=>"Terjadi kesalahan dalam penambahan data, mohon cek kembali dan coba lagi"]);
    }
}