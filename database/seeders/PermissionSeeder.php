<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear todos los permisos necesarios
        $permisos = [
            'ver dashboard',
            'gestionar usuarios',
            'gestionar roles',
            'gestionar permisos', // 👈 clave para el CRUD de permisos
            'ver ordenes',
            'crear ordenes',
            'editar ordenes',
            'eliminar ordenes',
            'ver reportes',
            'gestionar ingresos',
            'gestionar egresos',
            'gestionar productos',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // 2. Crear solo el rol "superadmin"
        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $superadmin->syncPermissions(Permission::all());

        $this->command->info('Permisos creados. Rol superadmin con todos los permisos.');
    }
}
