<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() &&  (Auth::user()->divisi == "Admin" ||Auth::user()->divisi == "Sekre" || Auth::user()->divisi == 'Acara' || Auth::user()->divisi == "Panitia")) {
            return $next($request);
       }
       return redirect()->route('index');
    }
}
