<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if(!$request->user() || !$request->user()->hasPermissionTo($permission)){
            if ($request->expectsJson()) {
                return response()->json(['message' => "You don't have permission"], 403);
            }
            abort(403, "Vous n'avez pas la permission d'accéder à cette ressource.");
        }
        return $next($request);
    }
}
