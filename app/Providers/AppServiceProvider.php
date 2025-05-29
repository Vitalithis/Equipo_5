<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Role;
use App\Models\Permission;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->booted(function () {
            if (Auth::check()) {
                $clienteId = Auth::user()->cliente_id;

                // Configurar Spatie para multitenancy por cliente
                app(PermissionRegistrar::class)->setPermissionsTeamId($clienteId);

                // Agregar scopes globales para filtrar Roles y Permisos por cliente_id
                $this->addExplicitGlobalScopes($clienteId);
            }
        });
    }

    protected function addExplicitGlobalScopes($clienteId)
    {
        // Scope global para Roles
        Role::addGlobalScope('tenant_roles', function (Builder $builder) use ($clienteId) {
            $builder->where('roles.cliente_id', $clienteId);
        });

        // Scope global para Permisos
        Permission::addGlobalScope('tenant_permissions', function (Builder $builder) use ($clienteId) {
            $builder->where('permissions.cliente_id', $clienteId);
        });

        // Nota: No aplicar scopes a tablas pivot (role_has_permissions/model_has_roles),
        // Spatie no usa modelos para ellas, solo consultas directas.
    }
}
