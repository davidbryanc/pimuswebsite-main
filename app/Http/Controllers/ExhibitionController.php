<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ExhibitionController extends Controller
{
    public function index($idlomba)
    {
        $viewable = [1, 4, 6, 7];
        $cabang = DB::table('cabang_lomba')->where('idlomba', $idlomba)->first();
        if (in_array($idlomba, $viewable)) {
            $submissions = DB::table('pengumpulan')->get();

            // Catcher jika data tidak lengkap
            foreach ($submissions as $submission) {
                if ($submission->idlomba == null) {
                    $idcabang = DB::table('kelompok')
                                ->where('idkelompok', '=', $submission->idkelompok)
                                ->first()->idlomba;

                    DB::table('pengumpulan')
                        ->where('id', '=', $submission->id)
                        ->update(['idlomba' => $idcabang]);
                }
            }

            $submissions = DB::table('pengumpulan')
                            ->where('idlomba', '=', $idlomba)
                            ->get();

            $groups = DB::table('kelompok')->get();

            $leaders = DB::table('users')
                    ->join('detail_user', 'users.nrp', '=', 'detail_user.nrp')
                    ->select('users.nama', 'detail_user.idkelompok')
                    ->where('detail_user.role', '=', 'Ketua')
                    ->get();

            return view('exhibition', [
                'submissions' => $submissions,
                'cabang' => $cabang,
                'leaders' => $leaders,
                'groups' => $groups
            ]);
        } else {
            abort(403, "$idlomba tidak memiliki Exhibition");
        }
    }

    public function vote($id)
    {
        try {
            if (Auth::user()->email_verified_at != null) {
                $likes = DB::table('pengumpulan')
                ->where('id', $id)->first()->like_count;

                $tikets = Auth::user()->tiket_vote;

                if ($tikets > 0) {
                    $decreaseTickets = DB::table('users')
                        ->where('nrp', (string)Auth::user()->nrp)
                        ->update([
                            'tiket_vote' => $tikets - 1
                        ]);

                    if ($decreaseTickets == true) {
                        DB::table('pengumpulan')
                            ->where('id', $id)
                            ->update([
                                'like_count' => $likes + 1
                            ]);
                    }
                    else {
                        DB::table('users')
                        ->where('nrp', (string)Auth::user()->nrp)
                        ->update([
                            'tiket_vote' => $tikets
                        ]);

                        throw new Exception("Error decrease tickets");
                    }

                    return back();
                }
                else
                    return redirect()->back()->withErrors(['errorMessage' => "Mohon maaf Tiket Vote anda sudah habis, Terima Kasih telah melakukan vote"]);
            }
            else
                return redirect()->back()->withErrors(['errorMessage' => "Anda masih belum melakukan verifikasi, mohon segera lakukan verifikasi"]);

        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(['errorMessage' => "Terjadi kesalahan saat melakukan proses Voting, silakan coba lagi"]);
        }
    }
}
