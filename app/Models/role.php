<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'guard_name',
        'description',
    ];

    public function givePermissionTo(...$permissions)
    {
        $permissions = collect($permissions)->flatten()->map(function ($permission) {
            if (is_string($permission)) {
                return \App\Models\Permission::where('name', $permission)->first();
            }
            return $permission;
        })->filter()->unique();

        foreach ($permissions as $permission) {
            \DB::table('role_has_permissions')->updateOrInsert(
                ['permission_id' => $permission->id, 'role_id' => $this->id]
            );
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return $this;
    }
}
