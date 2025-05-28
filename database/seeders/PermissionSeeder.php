<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permisos = [
            // Dashboard
            'ver dashboard',

            // Usuarios y roles
            'gestionar usuarios',
            'ver usuarios',
            'gestionar permisos',
            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles',

            // Ordenes
            'ver ordenes',
            'crear ordenes',
            'editar ordenes',
            'eliminar ordenes',

            // Finanzas
            'gestionar ingresos',
            'gestionar egresos',

            // Productos
            'gestionar productos',
            'gestionar catálogo',     // <-- Usado en el layout

            // Pedidos y descuentos
            'gestionar pedidos',       // <-- Usado para pedidos
            'gestionar descuentos',    // <-- Usado para sección descuentos

            // Proveedores ✅ AÑADIDO
            'gestionar proveedores',

            // Reportes
            'ver reportes',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
            ]);
        }

        // Crear rol admin si no existe
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        
        // Asignar todos los permisos al rol admin
        $admin->syncPermissions(Permission::all());

        $this->command->info('✅ Permisos creados y asignados al rol admin.');
    }
}
