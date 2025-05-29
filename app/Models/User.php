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

    public function roles()
    {
        return Role::join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', $this->id)
            ->where('model_has_roles.model_type', self::class)
            ->where(function ($query) {
                $query->whereNull('model_has_roles.cliente_id')
                    ->orWhere('model_has_roles.cliente_id', $this->cliente_id);
            })
            ->where('roles.cliente_id', $this->cliente_id) // Evita ambigüedad aquí
            ->select('roles.*', 'model_has_roles.cliente_id as pivot_cliente_id')
            ->get();
    }



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

    public function getPermissionsTeamId()
    {
        return $this->cliente_id;
    }

    public function getAllPermissions()
{
    $permissions = collect();

    foreach ($this->roles() as $role) {
        $permissions = $permissions->merge(
            $role->permissions()->where('permissions.cliente_id', $this->cliente_id)->get() // especificar tabla
        );
    }

    return $permissions->unique('id');
}

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
}
