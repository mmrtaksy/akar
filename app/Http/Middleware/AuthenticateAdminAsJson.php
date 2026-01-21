<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthenticateAdminAsJson
{
    public function handle($request, Closure $next)
    {
        
      

        if (!Auth::check()) {
            return $this->unauthorized($request);
        }

        if (Auth::user()->user_type_id != 1) {
            return $this->unauthorized($request);
        }

        return $next($request);
    }

    protected function unauthorized($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Yetkisiz erişim.'], 403);
        }

        return redirect()->route('xloginGet');
    }
}
