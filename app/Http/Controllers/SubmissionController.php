<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // // Submission Melalui Website

        $status = "";
        //Ketentuan agar bisa masuk submission
        //1. Yang mengumpulkan adalah ketua kelompok
        $user = Auth::user();
        // //Cek detail_user 
        $group = DB::table('user_details')
            ->join('teams', 'user_details.teams_id', '=', 'teams.id')
            ->join('competition_categories', 'teams.competition_categories_id', '=', 'competition_categories.id')
            ->join('submissions', 'teams.id', '=', 'submissions.teams_id', 'left')
            ->select('submissions.*', 'teams.*', 'user_details.*', 'competition_categories.*')
            ->where('user_details.nrp', '=', $user->nrp)
            ->where('user_details.role', '=', 'Ketua')
            ->where('teams.status', '=', 'Terima')
            ->whereIn('competition_categories.id', [1, 4, 7, 8, 9, 10, 11])
            ->get();

        // dd($group);

        if ($group->isNotEmpty()) {
            if (count($group) > 0) {
                return view('submission', ["group" => $group]);
            }
            else {
                $status = "Anda tidak termasuk kelompok apapun";
            }
        }
        else {
            $status = "Hanya anggota yang sudah mendaftar dan berperan menjadi ketua yang boleh mengumpulkan";
        }

        return redirect()->route('index')->with('status', $status);

        // Submission melalui Google Form

        // $listSubmission = DB::table('submission_dates')
        //                     ->join('competition_categories', 'submission_dates.id', '=', 'competition_categories.id')
        //                     ->select('submission_dates.*', 'competition_categories.name')
        //                     ->get();
                            
        // return view('submission', compact('listSubmission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitLink(Request $request)
    {
        $lomba = $request->idlomba;
        $idkelompok = $request->idkelompok;
        $linkEx = $request->linkEx;
        $linkProp = $request->linkProp;
        $description = $request->description;

        DB::table('submissions')->insert([
                    'teams_id' => $idkelompok,
                    'competition_categories_id' => $lomba,
                    'link_exhibition' => $linkEx,
                    'link_proposal' => $linkProp,
                    'description' => $description,
                    'like_count' => 0
        ]);


        // if ($lomba == 1 || $lomba == 7) {
        //     DB::table('submissions')->insert([
        //         'teams_id' => $idkelompok,
        //         'competition_categories_id' => $lomba,
        //         'link_drive' => $link,
        //         'like_count' => 0
        //     ]);
        //     $status = "Berhasil";
        //     $message = "Kelompok Anda telah berhasil mengunggah link pengumpulan.";
        // } else if ($lomba == 4 || $lomba == 8 || $lomba == 9 || $lomba == 10 || $lomba == 11) {
        //     DB::table('submissions')->insert([
        //         'teams_id' => $idkelompok,
        //         'competition_categories_id' => $lomba,
        //         'link_drive' => $link,
        //     ]);
        //     $status = "Berhasil";
        //     $message = "Kelompok Anda telah berhasil mengunggah link pengumpulan.";
        // } else if("a"){

        // } else {
        //     $status = "Gagal";
        //     $message = "Lomba kelompok Anda tidak perlu mengumpulkan link pengumpulan.";
        // }

        $status = "Berhasil";
        $message = "Kelompok Anda telah berhasil mengunggah link pengumpulan.";
        return response()->json(array(
            'status' => $status,
            'message' => $message
        ), 200);
    }
}
