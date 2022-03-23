<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class PenomoranMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next)
     {
       if(Auth::check()){
         if(Auth::user()->hasRole('menu_penomoran') OR Auth::user()->hasRole('superadmin')){
           return $next($request);
         }else{
           return redirect()->back();
         }
       }
       return redirect('login');
     }
}
