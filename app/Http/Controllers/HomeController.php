<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user() != null){
            if (Auth::user()->role == "Admin" || Auth::user()->role == "Sekre" || Auth::user()->role == "Panitia") {
                // dd(Auth::user()->role);
                return redirect()->route('admin.index');
            }
        } 
        return redirect()->route('index');
    }
}
