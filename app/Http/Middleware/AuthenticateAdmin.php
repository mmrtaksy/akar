<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class AuthenticateAdmin
{
    public function handle($request, Closure $next)
    {
        // Kullanıcının oturum açmış olup olmadığını kontrol et
        if (!Auth::check()) {
            return redirect()->route('xloginGet');
        }

        // Kullanıcının admin olup olmadığını kontrol et
        if (Auth::user()->user_type_id != 1) {
            return redirect()->route('xloginGet'); // Admin değilse, giriş sayfasına yönlendir
        }

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('xloginGet');
        }
    }
}