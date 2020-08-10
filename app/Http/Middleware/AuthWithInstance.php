<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthWithInstance
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
        if (! $request->expectsJson()) {//ログイン判定
            return redirect()->route('login');
        }else{
            $request->merge(["user" => Auth::user()]);
            dd($request);
            return $next($request);
        }
    }
}
