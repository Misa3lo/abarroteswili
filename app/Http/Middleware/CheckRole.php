<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Maneja una solicitud entrante.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // El rol del usuario es una columna ENUM('administrador', 'empleado') [cite: 78]
        if ($request->user() && $request->user()->rol == $role) {
            return $next($request);
        }

        // Si el usuario no tiene el rol, redirige al dashboard con un error
        return redirect('dashboard')->with('error', 'Acceso denegado. No tienes permisos de ' . $role . '.');
    }
}
