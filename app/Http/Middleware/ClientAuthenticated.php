<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si le client est connecté
        if (!Auth::guard('client')->check()) {
            return redirect()->route('clients.login');
        }
        
        return $next($request);
    }
}