<?php

namespace App\Http\Controllers;

use App\CompetitionCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegisterLomba extends Controller
{
    public function upload(Request $req)
    {
        try
        {
            // Generate idkelompok where is Empty
            $id = 1;
            $group = DB::table('teams')->where('id', '=', $id)->get();

            while (!$group->isEmpty()) {
                $id++;
                $group = DB::table('teams')->where('id', '=', $id)->get();
            }

            $idkelompok = $req->idKelompok != null ? $req->idKelompok : $id;
            $idLomba = $req->idLomba;

            // Get contest name
            $contest = DB::table('competition_categories')
                        ->where('id', '=', $idLomba)
                        ->get();

            $idLomba = $contest[0]->id;
            $contestName = $contest[0]->name;

            // Delete if there is residuals of detail_user
            DB::table('user_details')->where('teams_id',$idkelompok)->delete();

            // Delete all files that group had
            function rrmdir($dir) {
                if (is_dir($dir)) {
                    $objects = scandir($dir);
                    foreach ($objects as $object) {
                        if ($object != "." && $object != "..") {
                            if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                        }
                    }
                    reset($objects);
                    rmdir($dir);
                }
            }
            
            rrmdir("storage/formPendaftaran/".$contestName."/".$idkelompok);
            rrmdir("storage/suratPernyataan/".$contestName."/".$idkelompok);
            rrmdir("storage/pasFoto/".$contestName."/".$idkelompok);
            rrmdir("storage/ktm/".$contestName."/".$idkelompok);
            rrmdir("storage/borang/".$contestName."/".$idkelompok);
            // rrmdir("storage/jadwalKuliah/".$contestName."/".$idkelompok);
            rrmdir("storage/rekapIPK/".$contestName."/".$idkelompok);
            rrmdir("storage/daftarPrestasi/".$contestName."/".$idkelompok);
            
            // Move files to directory /public/storage
            $formPendaftaran = $req->file('formDaftar');
            $formPendaftaran->move('storage/formPendaftaran/'.$contestName.'/'.$idkelompok,$formPendaftaran->getClientOriginalName());
            $path_formPendaftaran = 'storage/formPendaftaran/'.$contestName.'/'.$idkelompok.'/'.$formPendaftaran->getClientOriginalName();
            $suratPernyataan = $req->file('suratPernyataan');
            $suratPernyataan->move('storage/suratPernyataan/'.$contestName.'/'.$idkelompok,$suratPernyataan->getClientOriginalName());
            $path_suratPernyataan = 'storage/suratPernyataan/'.$contestName.'/'.$idkelompok.'/'.$suratPernyataan->getClientOriginalName();
            $jumlahAnggota = $req->jumlahAnggota;

            // Make new/update data in table kelompok
            $group = DB::table('teams')->where('id', '=', $idkelompok)->get();
            // dd($group);

            if ($group->isEmpty()) {
                DB::table('teams')->insert([
                    'id' => $idkelompok,
                    'competition_categories_id' => $idLomba,
                    'registration_form' => $path_formPendaftaran,
                    'statement_letter' => $path_suratPernyataan,
                    'status' => 'Pending'
                ]); 
            }
            else {
                DB::table('teams')->where('id',$idkelompok)->update([
                    'registration_form' => $path_formPendaftaran,
                    'statement_letter' => $path_suratPernyataan,
                    'status' => 'Pending'
                ]);  
            }

            for($i=1; $i<=$jumlahAnggota; $i++)
            {
                $nrp = $req->nrpAnggota[$i-1];           

                $pasFoto = $req->file("pasFoto$i");
                $pasFoto->move('storage/pasFoto/'.$contestName.'/'.$idkelompok,$pasFoto->getClientOriginalName());
                $path_pasFoto = 'storage/pasFoto/'.$contestName.'/'.$idkelompok.'/'.$pasFoto->getClientOriginalName();

                $ktm = $req->file("ktm$i");
                $ktm->move('storage/ktm/'.$contestName.'/'.$idkelompok,$ktm->getClientOriginalName());
                $path_ktm = 'storage/ktm/'.$contestName.'/'.$idkelompok.'/'.$ktm->getClientOriginalName();

                if ($i == 1) {
                    $role = "Ketua";
                    $idLine = $req->line;
                    $wa = $req->wa;
                }
                else {
                    $role = "Anggota";
                    $idLine = null;
                    $wa = null;
                }

                // dd($nrp);
                DB::table('user_details')->insert([
                    'nrp' => $nrp,
                    'id_card' => $path_ktm,
                    'self_photo' => $path_pasFoto,
                    'line' => $idLine,
                    'phone_number' => $wa,
                    'teams_id' => $idkelompok,
                    'role' => $role
                ]);

                // if($idLomba<8)
                // {
                //     $jadwalKuliah = $req->file("jadwalKuliah$i");
                //     $jadwalKuliah->move('storage/jadwalKuliah/'.$contestName.'/'.$idkelompok,$jadwalKuliah->getClientOriginalName());
                //     $path_jadwalKuliah = 'storage/jadwalKuliah/'.$contestName.'/'.$idkelompok.'/'.$jadwalKuliah->getClientOriginalName();
                //     DB::table('user_details')->where('nrp', $req->nrpAnggota[$i-1])->update([
                //         'schedule' => $path_jadwalKuliah,
                //     ]);
                // }
            }
            switch($idLomba)
            {
                case 1:
                    $borang = $req->file("borang");
                    $borang->move('storage/borang/'.$contestName.'/'.$idkelompok,$borang->getClientOriginalName());
                    $path_borang = 'storage/borang/'.$contestName.'/'.$idkelompok.'/'.$borang->getClientOriginalName();

                    $rekapIPK = $req->file("rekapIPK");
                    $rekapIPK->move('storage/rekapIPK/'.$contestName.'/'.$idkelompok,$rekapIPK->getClientOriginalName());
                    $path_rekapIPK = 'storage/rekapIPK/'.$contestName.'/'.$idkelompok.'/'.$rekapIPK->getClientOriginalName();

                    $daftarPrestasi = $req->file("daftarPrestasi");
                    $daftarPrestasi->move('storage/daftarPrestasi/'.$contestName.'/'.$idkelompok,$daftarPrestasi->getClientOriginalName());
                    $path_daftarPrestasi = 'storage/daftarPrestasi/'.$contestName.'/'.$idkelompok.'/'.$daftarPrestasi->getClientOriginalName();

                    DB::table('user_details')->where('nrp', $req->nrpAnggota[0])->update([
                        'borang' => $path_borang,
                        'gpa_recap' => $path_rekapIPK,
                        'achievement_list' => $path_daftarPrestasi
                    ]);
                break;
                case 5:
                    $jenisKompetisi = $req->jenisKompetisi;
                    DB::table('user_details')->where('nrp', $req->nrpAnggota[0])->update([
                        'competition_type' => $jenisKompetisi
                    ]);
                break;
                // default:
                //     $jenisKelompok = $req->jenisKelompok;
                //     DB::table('teams')->where('id',$idkelompok)->update([
                //         'team_type' => $jenisKelompok
                //     ]);
                // break;
            }

            $pesan = 'Registrasi berhasil!';
            return view('registration', ['pesan' => $pesan]);
        }
        catch(Exception $ex){
            // Delete all residuals data            
            $group = DB::table('user_details')
                        ->join('teams', 'user_details.teams_id', '=', 'teams.id')
                        ->select(DB::raw('user_details.nrp as nrpKetua'), 'teams.status')
                        ->where('user_details.role', '=', "Ketua")
                        ->get();
            
            if ($group->isEmpty()) {
                foreach ($group as $groupStat) {
                    if ($groupStat->status != "Tolak") {
                        DB::table('user_details')
                            ->where('teams_id',$idkelompok)
                            ->where('role', '!=', "Ketua")
                            ->delete();
    
                        DB::table('teams')->where('id',$idkelompok)->update([
                            'status' => 'Tolak'
                        ]);
                    }
                    else {
                        DB::table('user_details')->where('teams_id',$idkelompok)->delete();
                        DB::table('teams')->where('id',$idkelompok)->delete();
                    }
                }
            }
            else {                
                DB::table('user_details')->where('teams_id',$idkelompok)->delete();
                DB::table('teams')->where('id',$idkelompok)->delete();
            }

            $pesan = 'GAGAL melakukan registrasi !\nPerhatikan apakah: \n    Ada anggota yang belum registrasi awal\n   Salah mengisi NRP\n   Penamaan file salah';
            return view('registration', ['pesan' => $pesan]);
        }       
    }

    public function showCabang()
    {
        $userId = isset(Auth::user()->nrp) ? Auth::user()->nrp : null;
        $id = $_GET['cabang'];

        $user = DB::table('user_details')
                ->join('teams','user_details.teams_id','=','teams.id')
                ->join('competition_categories','teams.competition_categories_id','=','competition_categories.id')
                ->where('user_details.nrp','=',$userId)
                ->where('teams.competition_categories_id','=',$id)
                ->get();

        if($id == 8){
            $user = DB::table('user_details')
                ->join('teams','user_details.teams_id','=','teams.id')
                ->join('competition_categories','teams.competition_categories_id','=','competition_categories.id')
                ->where('user_details.nrp','=',$userId)
                ->whereIn('teams.competition_categories_id', [8, 9, 10, 11])
                ->get();
        }

        // dd($id);


        $category = CompetitionCategory::find($id);

        $date = DB::table('dates')->get();

        if($user->isEmpty())
        {
            $user = null;
        }

        // return view('cabang', ['cabang' => $cabang, 'user' => $user, 'userID'=>$userId, 'tanggal'=>$tanggal]);
        return view('cabang', compact('category', 'user', 'date', 'userId'));   
    }

    public function showRegister()
    {
        $id = $_GET['cabang'];

        $category = CompetitionCategory::find($id);

        $userId = Auth::user()->nrp;
        
        $team = DB::table('user_details')
                        ->join('teams','user_details.teams_id','=','teams.id')
                        ->where('user_details.nrp','=',$userId)
                        ->where('teams.competition_categories_id','=',$id)
                        ->orderBy('teams.id')
                        ->get();

        $teamLeader = DB::table('users')
                            ->join('user_details', 'users.nrp', '=', 'user_details.nrp')
                            ->join('teams','user_details.teams_id','=','teams.id')
                            ->select('users.name', 'teams.id')
                            ->where('teams.competition_categories_id','=',$id)
                            ->where('user_details.role', '=', "Ketua")
                            ->orderBy('teams.id')
                            ->get();
                            
        if($team->isEmpty())
        {
            $team = null;
            $teamLeader = null;
        }
        
        //return view('registerlomba', ['cabang' => $category, 'kelompok' => $kelompok, 'ketuakelompok'=>$ketuakelompok]);
        return view('registerlomba', compact('category', 'team', 'teamLeader'));
    }

    public function showRegistration()
    {
        $date = DB::table('dates')->get();

        return view('registration', compact('date'));
    }
}
