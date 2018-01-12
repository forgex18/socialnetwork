<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class admin
{

    public function handle($request, Closure $next)
    {
        //mira si el usuario esta logueado y si es admin o no
        if(Auth::check() && Auth::user()->isRole()=="admin"){
            return $next($request);
        }
        return redirect('login');
    }
}
