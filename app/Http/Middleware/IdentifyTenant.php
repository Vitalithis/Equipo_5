<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\PermissionRegistrar;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        // Permitir acceso si es localhost o dominio base sin subdominio
        if (in_array($host, ['localhost', '127.0.0.1', 'plantaseditha.me'])) {
            return $next($request);
        }

        $subdominio = explode('.', $host)[0];
        $cliente = Cliente::where('subdominio', $subdominio)->first();

        if (!$cliente) {
            abort(404, 'Cliente no encontrado');
        }

        app()->instance('clienteActual', $cliente);

        if (Auth::check()) {
            $user = Auth::user();

            // Soporte tiene acceso global, sin cliente_id para permisos
            if ($user->hasRole('soporte')) {
                app(PermissionRegistrar::class)->setPermissionsTeamId(null);
                return $next($request);
            }

            // Validar cliente del usuario
            if ($user->cliente_id !== $cliente->id) {
                abort(403, 'No tienes acceso a este cliente');
            }

            // Establecer cliente para Spatie
            app(PermissionRegistrar::class)->setPermissionsTeamId($cliente->id);

            $this->ensurePivotClienteIdCorrect($user, $cliente->id);
        }

        return $next($request);
    }

    protected function ensurePivotClienteIdCorrect($user, $clienteId)
    {
        foreach ($user->roles as $role) {
            $pivot = $role->pivot;
            if ($pivot && $pivot->cliente_id != $clienteId) {
                $user->roles()->updateExistingPivot($role->id, ['cliente_id' => $clienteId]);
            }
        }
    }
}
