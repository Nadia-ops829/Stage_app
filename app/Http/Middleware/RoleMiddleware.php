<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Gestion spéciale pour super_admin
        if ($role === 'super_admin' && Auth::user()->role === 'super_admin') {
            return $next($request);
        }

        if (Auth::user()->role !== $role) {
            abort(403, 'Accès refusé – Rôle insuffisant.');
        }

        return $next($request);
    }
}
