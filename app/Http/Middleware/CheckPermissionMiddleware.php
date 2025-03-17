<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();

        // Определяем секцию (из URI запроса)
        $section = $request->segment(2); // Получаем вторую часть URL (например, "articles")


        if (!$user || !$user->hasPermission($permission, $section)) {
            abort(403, 'У вас нет разрешения на это действие');
        }

        return $next($request);
//        $user = Auth::user();
//
//        // Если пользователь не аутентифицирован — просто пропускаем его
//        if (!$user) {
//            return $next($request);
//        }
//
//        // Определяем секцию (из URI запроса)
//        $section = $request->segment(2);
//
//        if (!$user->hasPermission($permission, $section)) {
//            abort(403, 'У вас нет разрешения на это действие');
//        }
//
//        return $next($request);
    }
}

