<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Cliente;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles {
        assignRole as traitAssignRole;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'must_change_password',
        'cliente_id',
        'descuento_personalizado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'must_change_password' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Roles filtrados por cliente actual.
     */
    public function filteredRoles()
    {
        return $this->roles
            ->where('cliente_id', $this->cliente_id)
            ->values();
    }

    /**
     * Reimplementación de assignRole respetando cliente_id.
     */
    public function assignRole(...$roles)
    {
        $roles = collect($roles)->flatten()->map(function ($role) {
            if (is_string($role)) {
                return Role::where('name', $role)
                    ->where(function ($query) {
                        $query->where('cliente_id', $this->cliente_id)
                            ->orWhereNull('cliente_id');
                    })
                    ->first();
            }
            return $role;
        })->filter();

        return $this->traitAssignRole(...$roles);
    }

    /**
     * Necesario si usas teams o cliente_id como separación de permisos.
     */
    public function getPermissionsTeamId()
    {
        return $this->cliente_id;
    }

    /**
     * Obtener todos los permisos por roles, filtrados por cliente.
     */
    public function getAllPermissions()
    {
        $permissions = collect();

        foreach ($this->filteredRoles() as $role) {
            $permissions = $permissions->merge(
                $role->permissions()->where('permissions.cliente_id', $this->cliente_id)->get()
            );
        }

        return $permissions->unique('id');
    }

    /**
     * Validar si tiene el permiso especificado.
     */
    public function hasPermissionTo($permission, $guardName = null): bool
    {
        $permissions = $this->getAllPermissions();

        if (is_string($permission)) {
            return $permissions->contains('name', $permission);
        }

        if ($permission instanceof \Spatie\Permission\Models\Permission) {
            return $permissions->contains('id', $permission->id);
        }

        return false;
    }
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'usuario_id');
    }
}
