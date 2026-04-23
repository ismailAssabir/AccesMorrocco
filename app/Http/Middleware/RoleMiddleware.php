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
     * @param  string  $roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Check if user has any of the required roles
        // We use Spatie's hasAnyRole if it's available, otherwise check the 'type' column as fallback
        $hasRole = false;
        
        if (method_exists($request->user(), 'hasAnyRole')) {
            $hasRole = $request->user()->hasAnyRole($roles);
        } else {
            $hasRole = in_array($request->user()->type, $roles);
        }

        if (!$hasRole) {
            if ($request->expectsJson()) {
                return response()->json(['message' => "Unauthorized access."], 403);
            }
            abort(403, "Vous n'avez pas le rôle requis pour accéder à cette page.");
        }

        return $next($request);
    }
}
