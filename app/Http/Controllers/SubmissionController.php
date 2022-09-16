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

        // $status = "";
        // //Ketentuan agar bisa masuk submission
        // //1. Yang mengumpulkan adalah ketua kelompok
        // $user = Auth::user();
        // // //Cek detail_user 
        // $group = DB::table('detail_user')
        //     ->join('kelompok', 'detail_user.idkelompok', '=', 'kelompok.idkelompok')
        //     ->join('cabang_lomba', 'kelompok.idlomba', '=', 'cabang_lomba.idlomba')
        //     ->join('pengumpulan', 'kelompok.idkelompok', '=', 'pengumpulan.idkelompok', 'left')
        //     ->select(DB::raw('kelompok.idkelompok as idkelompok_ketua'), 'detail_user.*', 'kelompok.*', 'cabang_lomba.*', 'pengumpulan.*')
        //     ->where('detail_user.nrp', '=', $user->nrp)
        //     ->where('detail_user.role', '=', 'Ketua')
        //     ->where('kelompok.status', '=', 'Terima')
        //     ->get();

        // if ($group->isNotEmpty()) {
        //     if (count($group) > 0) {
        //         return view('submission', ["group" => $group]);
        //     }
        //     else {
        //         $status = "Anda tidak termasuk kelompok apapun";
        //     }
        // }
        // else {
        //     $status = "Hanya anggota yang sudah mendaftar dan berperan menjadi ketua yang boleh mengumpulkan";
        // }

        // return redirect()->route('index')->with('status', $status);

        // Submission melalui Google Form

        $listSubmission = DB::table('submission_dates')
                            ->join('competition_categories', 'submission_dates.id', '=', 'competition_categories.id')
                            ->select('submission_dates.*', 'competition_categories.name')
                            ->get();
                            
        return view('submission', compact('listSubmission'));
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
        $link = $request->linkdrive;
        if ($lomba == 6 || $lomba == 7) {
            DB::table('pengumpulan')->insert([
                'idkelompok' => $idkelompok,
                'link_drive' => $link,
                'like_count' => 0
            ]);
            $status = "Berhasil";
            $message = "Kelompok Anda telah berhasil mengunggah link pengumpulan.";
        } else if ($lomba == 4 || $lomba == 8 || $lomba == 9 || $lomba == 10 || $lomba == 11) {
            DB::table('pengumpulan')->insert([
                'idkelompok' => $idkelompok,
                'link_drive' => $link,
            ]);
            $status = "Berhasil";
            $message = "Kelompok Anda telah berhasil mengunggah link pengumpulan.";
        } else {
            $status = "Gagal";
            $message = "Lomba kelompok Anda tidak perlu mengumpulkan link pengumpulan.";
        }
        return response()->json(array(
            'status' => $status,
            'message' => $message
        ), 200);
    }
}
