<?php

namespace App\Http\Controllers;

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
            $idkelompok = 1;
            $group = DB::table('kelompok')->where('idkelompok', '=', $idkelompok)->get();

            while (!$group->isEmpty()) {
                $idkelompok++;
                $group = DB::table('kelompok')->where('idkelompok', '=', $idkelompok)->get();
            }

            $idkelompok = $req->idKelompok != null ? $req->idKelompok : $idkelompok;
            $idLomba = $req->idLomba;

            // Get contest name
            $contestDB = DB::table('cabang_lomba')
                        ->where('idlomba', '=', $idLomba)
                        ->get();

            foreach ($contestDB as $contest) {
                $idLomba = $contest->idlomba;
                $contestName = $contest->nama;
            }

            // Delete if there is residuals of detail_user
            DB::table('detail_user')->where('idkelompok',$idkelompok)->delete();

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
            rrmdir("storage/jadwalKuliah/".$contestName."/".$idkelompok);
            rrmdir("storage/borang/".$contestName."/".$idkelompok);
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
            $group = DB::table('kelompok')->where('idkelompok', '=', $idkelompok)->get();

            if ($group->isEmpty()) {
                DB::table('kelompok')->insert([
                    'idkelompok' => $idkelompok,
                    'idlomba' => $idLomba,
                    'formulir_pendaftaran' => $path_formPendaftaran,
                    'surat_pernyataan' => $path_suratPernyataan,
                    'status' => 'Pending'
                ]); 
            }
            else {
                DB::table('kelompok')->where('idKelompok',$idkelompok)->update([
                    'formulir_pendaftaran' => $path_formPendaftaran,
                    'surat_pernyataan' => $path_suratPernyataan,
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
                }
                else {
                    $role = "Anggota";
                    $idLine = null;
                }

                DB::table('detail_user')->insert([
                    'nrp' => $nrp,
                    'ktm' => $path_ktm,
                    'pas_foto' => $path_pasFoto,
                    'line' => $idLine,
                    'idkelompok' => $idkelompok,
                    'role' => $role
                ]);

                if($idLomba<8)
                {
                    $jadwalKuliah = $req->file("jadwalKuliah$i");
                    $jadwalKuliah->move('storage/jadwalKuliah/'.$contestName.'/'.$idkelompok,$jadwalKuliah->getClientOriginalName());
                    $path_jadwalKuliah = 'storage/jadwalKuliah/'.$contestName.'/'.$idkelompok.'/'.$jadwalKuliah->getClientOriginalName();
                    DB::table('detail_user')->where('nrp', $req->nrpAnggota[$i-1])->update([
                        'jadwal_kuliah' => $path_jadwalKuliah,
                    ]);
                }
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
                    DB::table('detail_user')->where('nrp', $req->nrpAnggota[0])->update([
                        'borang' => $path_borang,
                        'rekap_ipk' => $path_rekapIPK,
                        'daftar_prestasi' => $path_daftarPrestasi
                    ]);
                break;
                case 5:
                    $jenisKompetisi = $req->jenisKompetisi;
                    DB::table('detail_user')->where('nrp', $req->nrpAnggota[0])->update([
                        'jenis_kompetisi' => $jenisKompetisi
                    ]);
                break;
                default:
                    $jenisKelompok = $req->jenisKelompok;
                    DB::table('kelompok')->where('idkelompok',$idkelompok)->update([
                        'jenis_kelompok' => $jenisKelompok
                    ]);
                break;
            }

            $pesan = 'Registrasi berhasil!';
            return view('registration', ['pesan' => $pesan]);
        }
        catch(\Exception $ex){
            // Delete all residuals data            
            $group = DB::table('detail_user')
                        ->join('kelompok', 'detail_user.idkelompok', '=', 'kelompok.idkelompok')
                        ->select(DB::raw('detail_user.nrp as nrpKetua'), 'kelompok.status')
                        ->where('detail_user.role', '=', "Ketua")
                        ->get();
            
            if ($group->isEmpty()) {
                foreach ($group as $groupStat) {
                    if ($groupStat->status != "Tolak") {
                        DB::table('detail_user')
                            ->where('idkelompok',$idkelompok)
                            ->where('role', '!=', "Ketua")
                            ->delete();
    
                        DB::table('kelompok')->where('idKelompok',$idkelompok)->update([
                            'status' => 'Tolak'
                        ]);
                    }
                    else {
                        DB::table('detail_user')->where('idkelompok',$idkelompok)->delete();
                        DB::table('kelompok')->where('idKelompok',$idkelompok)->delete();
                    }
                }
            }
            else {                
                DB::table('detail_user')->where('idkelompok',$idkelompok)->delete();
                DB::table('kelompok')->where('idKelompok',$idkelompok)->delete();
            }

            $pesan = 'GAGAL melakukan registrasi !\nPerhatikan apakah: \n    Ada anggota yang belum registrasi awal\n   Salah mengisi NRP\n   Penamaan file salah';
            return view('registration', ['pesan' => $pesan]);
        }       
    }

    public function showCabang()
    {
        $userId = isset(Auth::user()->nrp) ? Auth::user()->nrp : null;
        $id = $_GET['cabang'];
        $user = DB::table('detail_user')
                ->join('kelompok','detail_user.idkelompok','=','kelompok.idkelompok')
                ->join('cabang_lomba','kelompok.idlomba','=','cabang_lomba.idlomba')
                ->where('detail_user.nrp','=',$userId)
                ->where('kelompok.idlomba','=',$id)
                ->get();
        $cabang = DB::table('cabang_lomba')->where('idlomba',$id)->get();

        $tanggal = DB::table('tanggal')->get();

        if($user->isEmpty())
        {
            $user = null;
        }

        return view('cabang', ['cabang' => $cabang, 'user' => $user, 'userID'=>$userId, 'tanggal'=>$tanggal]);
    }

    public function showRegister()
    {
        $id = $_GET['cabang'];
        $cabang = DB::table('cabang_lomba')->where('idlomba',$id)->get();
        $userId = Auth::user()->nrp;
        $kelompok = DB::table('detail_user')
                        ->join('kelompok','detail_user.idkelompok','=','kelompok.idkelompok')
                        ->where('detail_user.nrp','=',$userId)
                        ->where('kelompok.idlomba','=',$id)
                        ->orderBy('kelompok.idkelompok')
                        ->get();

        $ketuakelompok = DB::table('users')
                            ->join('detail_user', 'users.nrp', '=', 'detail_user.nrp')
                            ->join('kelompok','detail_user.idkelompok','=','kelompok.idkelompok')
                            ->select('users.nama', 'kelompok.idkelompok')
                            ->where('kelompok.idlomba','=',$id)
                            ->where('detail_user.role', '=', "Ketua")
                            ->orderBy('kelompok.idkelompok')
                            ->get();
        
        if($kelompok->isEmpty())
        {
            $kelompok = null;
            $ketuakelompok = null;
        }
        
        return view('registerlomba', ['cabang' => $cabang, 'kelompok' => $kelompok, 'ketuakelompok'=>$ketuakelompok]);
    }

    public function showRegistration()
    {
        $tanggal = DB::table('tanggal')->get();

        return view('registration', ['tanggal' => $tanggal]);
    }
}
