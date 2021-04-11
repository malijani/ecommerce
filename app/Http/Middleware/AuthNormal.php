<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthNormal
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
            if(Auth::user()->isAdmin()){
                return $next($request);
            } elseif(Auth::user()->isNormal()) {
                return $next($request);
            } else {
                return redirect(route('home'));
            }
        }
        return redirect(route('login'));
    }
}
