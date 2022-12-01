<?php

namespace App\Http\Controllers;

use App\CompetitionCategory;
use App\Submission;
use App\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ExhibitionController extends Controller
{
    public function index($idlomba)
    {
        $viewable = [4, 7];
        $cabang = CompetitionCategory::find($idlomba);
        if (in_array($idlomba, $viewable)) {
            $submissions = Submission::all();

            // Catcher jika data tidak lengkap
            foreach ($submissions as $submission) {
                if ($submission->competition_categories_id == null) {
                    $idcabang = DB::table('teams')
                                ->where('id', '=', $submission->teams_id)
                                ->first()->competition_categories_id;

                    // DB::table('pengumpulan')
                    //     ->where('id', '=', $submission->id)
                    //     ->update(['idlomba' => $idcabang]);

                    Submission::where('id', $submission->id)->update(['competition_categories_id' => $idcabang]);
                }
            }

            
            $submissions = Submission::where('competition_categories_id', $idlomba)->get();
            $groups = Team::all();

            $leaders = DB::table('users')
                    ->join('user_details', 'users.nrp', '=', 'user_details.nrp')
                    ->select('users.name', 'user_details.teams_id')
                    ->where('user_details.role', '=', 'Ketua')
                    ->get();

            // dd($submission);

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
                $likes = DB::table('submissions')
                ->where('id', $id)->first()->like_count;

                $tikets = Auth::user()->vote_tickets;

                if ($tikets > 0) {
                    $decreaseTickets = DB::table('users')
                        ->where('nrp', (string)Auth::user()->nrp)
                        ->update([
                            'vote_tickets' => $tikets - 1
                        ]);

                    if ($decreaseTickets == true) {
                        DB::table('submissions')
                            ->where('id', $id)
                            ->update([
                                'like_count' => $likes + 1
                            ]);
                    }
                    else {
                        DB::table('users')
                        ->where('nrp', (string)Auth::user()->nrp)
                        ->update([
                            'vote_tickets' => $tikets
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
