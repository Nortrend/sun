<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $section): Response
    {
        $user = Auth::user();

        if (!$user || !$user->roles->contains('title', "moderator_{$section}")) {
            abort(403, 'У вас нет доступа к этому разделу');
        }

        return $next($request);
//        $user = Auth::user();
//
//        // Если пользователь не аутентифицирован — просто пропускаем его
//        if (!$user) {
//            return $next($request);
//        }
//
//        if (!$user->roles->contains('title', "moderator_{$section}")) {
//            abort(403, 'У вас нет доступа к этому разделу');
//        }
//
//        return $next($request);
    }
}
