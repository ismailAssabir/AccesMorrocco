<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // التحقق من أن المستخدم مسجل الدخول
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $hasRole = false; // تعريف المتغير بقيمة افتراضية

        // التحقق باستخدام Spatie Permission إذا كان متاحاً
        if (method_exists($request->user(), 'hasAnyRole')) {
            try {
                $hasRole = $request->user()->hasAnyRole($roles);
            } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
                $hasRole = false;
            }
        }

        // إذا لم يتحقق بعد، نتحقق باستخدام عمود 'type'
        if (!$hasRole) {
            $userType = $request->user()->type ?? $request->user()->role ?? null;
            $hasRole = in_array($userType, $roles);
        }

        // إذا لم يكن للمستخدم الدور المطلوب
        if (!$hasRole) {
            if ($request->expectsJson()) {
                return response()->json(['message' => "Unauthorized access."], 403);
            }
            abort(403, "Vous n'avez pas le rôle requis pour accéder à cette page.");
        }

        return $next($request);
    }
}