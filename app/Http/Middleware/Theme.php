<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Theme
{
    public function handle(Request $request, Closure $next)
    {
        $theme = Cookie::get('theme', 'light'); // Varsayılan olarak 'light'
        view()->share('theme', $theme);

        return $next($request);
    }
}
