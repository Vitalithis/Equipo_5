<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BypassPermissionsForSoporte
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole('soporte')) {
            // Elimina los middlewares de permisos de Spatie para este request
            app()->forgetInstance(\Spatie\Permission\Middlewares\PermissionMiddleware::class);
            app()->forgetInstance(\Spatie\Permission\Middlewares\RoleMiddleware::class);
            // Permiso absoluto: omite cualquier validación posterior
            return $next($request);
        }
        return $next($request);
    }
} 