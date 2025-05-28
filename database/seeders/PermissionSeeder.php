<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar cache de permisos para evitar conflictos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permisos = [
            'ver dashboard',
            'gestionar usuarios',
            'ver usuarios',
            'gestionar permisos',
            'ver roles',
            'crear roles',
            'editar roles',
            'eliminar roles',
            'ver ordenes',
            'crear ordenes',
            'editar ordenes',
            'eliminar ordenes',
            'gestionar ingresos',
            'gestionar egresos',
            'gestionar productos',
            'gestionar proveedores',
            'gestionar catálogo',
            'gestionar pedidos',
            'gestionar descuentos',
            'ver reportes',
            'gestionar tareas',

        ];

        foreach ($permisos as $nombre) {
            Permission::firstOrCreate([
                'name' => $nombre,
                'guard_name' => 'web',
            ]);
        }

        // Asegurar que el rol admin exista
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // Asignar todos los permisos al rol admin
        $adminRole->syncPermissions(Permission::all());

        $this->command->info("✅ Permisos creados y asignados correctamente al rol admin.");
    }
}
