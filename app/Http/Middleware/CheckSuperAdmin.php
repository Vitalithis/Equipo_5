<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Verifica si el usuario autenticado tiene rol de superadmin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario no está autenticado o no es superadmin, denegar acceso
        if (!auth()->check() || auth()->user()->role !== 'superadmin') {
            // Opción 1: Redirigir al dashboard con error
            return redirect()->route('dashboard')->with('error', 'Acceso no autorizado');

            // Opción 2: Retornar 403 (Forbidden)
            // abort(403, 'Acceso solo para superadministradores');
        }

        return $next($request);
    }
}