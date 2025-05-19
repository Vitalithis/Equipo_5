<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear los permisos
        $permisos = [
            // Sistema
            'ver dashboard',
            'gestionar usuarios',
            'gestionar roles',

            // Producción / Operaciones
            'ver ordenes',
            'crear ordenes',
            'editar ordenes',
            'eliminar ordenes',

            // Finanzas
            'ver reportes',
            'gestionar ingresos',
            'gestionar egresos',

            // Productos
            'gestionar productos',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // 2. Crear los roles
        $roles = [
            'superadmin',
            'admin',
            'contable',
            'operario',
            'usuario',
        ];

        foreach ($roles as $nombreRol) {
            Role::firstOrCreate(['name' => $nombreRol]);
        }

        // 3. Asignar permisos a roles
        Role::findByName('superadmin')->syncPermissions(Permission::all());

        Role::findByName('admin')->syncPermissions([
            'ver dashboard',
            'gestionar usuarios',
            'gestionar roles',
            'gestionar productos',
            'ver ordenes',
            'crear ordenes',
            'editar ordenes',
        ]);

        Role::findByName('contable')->syncPermissions([
            'ver dashboard',
            'ver reportes',
            'gestionar ingresos',
            'gestionar egresos',
        ]);

        Role::findByName('operario')->syncPermissions([
            'ver ordenes',
            'crear ordenes',
            'editar ordenes',
        ]);

        Role::findByName('usuario')->syncPermissions([
            'ver dashboard',
        ]);

        $this->command->info('Permisos y roles asignados correctamente.');
    }
}
