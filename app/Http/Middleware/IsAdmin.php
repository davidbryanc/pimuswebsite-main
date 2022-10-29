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
        if (Auth::user() &&  (Auth::user()->role == "Admin" ||Auth::user()->role == "Sekre" || Auth::user()->role == 'Acara' || Auth::user()->role == "Panitia")) {
            return $next($request);
       }
       return redirect()->route('index');
    }
}
