<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DisableVerify
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
        if (Auth::check()) {
            if (! Auth::user()->isVerified()) {
                return $next($request);
            } else {
                return redirect(route('dashboard.index'))
                    ->with('warning', 'حساب کاربری شما تایید شده!');
            }
        }
        return redirect(route('login'));
    }
}
