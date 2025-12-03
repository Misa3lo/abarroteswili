<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Maneja la solicitud entrante.
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Si el usuario no está logueado, redirigir al login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Si el rol del usuario NO coincide con el rol requerido, denegar acceso
        if (Auth::user()->rol !== $role) {
            return redirect('/dashboard')->with('error', 'Acceso denegado. Permisos insuficientes para esta sección.');
        }

        return $next($request);
    }
}
