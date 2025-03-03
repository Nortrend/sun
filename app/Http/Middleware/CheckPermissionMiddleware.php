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
        $section = $request->segment(2); // Получаем первую часть URL (например, "articles")
//        dump([
//            'user_id' => $user?->id,
//            'permission' => $permission,
//            'section' => $section,
//            'has_permission' => $user ? $user->hasPermission($permission, $section) : false
//        ]);

        if (!$user || !$user->hasPermission($permission, $section)) {
            abort(403, 'У вас нет разрешения на это действие');
        }

        return $next($request);
    }
}

