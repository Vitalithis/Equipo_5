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
        // Limpiar cache de permisos
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
            'gestionar catálogo',
            'gestionar pedidos',
            'gestionar descuentos',
            'ver reportes',
            'gestionar tareas',

            // Permisos para soporte
            'ver panel soporte',
            'crear cliente',
            'gestionar clientes',
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

        // Crear rol soporte si no existe
        $rolSoporte = Role::firstOrCreate([
            'name' => 'soporte',
            'guard_name' => 'web',
        ]);

        // Asignar permisos del soporte
        $rolSoporte->syncPermissions([
            'ver panel soporte',
            'crear cliente',
            'gestionar clientes',

        ]);

        $this->command->info("Permisos y rol soporte creados correctamente.");
    }
}
