<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Si l'utilisateur est super_admin, il a accès à tout
        if ($user->role === 'super_admin') {
            return $next($request);
        }
        
        // Vérifier si l'utilisateur a l'un des rôles autorisés
        if (!in_array($user->role, $roles)) {
            abort(403, 'Accès refusé – Rôle insuffisant.');
        }

        return $next($request);
    }
}
