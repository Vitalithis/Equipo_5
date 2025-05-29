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
            // Pedidos y descuentos

            'gestionar pedidos',
            'gestionar descuentos',

            'gestionar descuentos',    // <-- Usado para sección descuentos

            // Proveedores ✅ AÑADIDO
            'gestionar proveedores',

            // Mantenimiento Infrastructura
            'ver reportes infraestructura', // listado de arreglos que se hacen, tienen que tener, titulo, costo, fecha, descripcion
            'gestionar infraestructura',
            // Reportes

            'ver reportes',
            'gestionar tareas',
            'gestionar fertilizantes',
            'gestionar cuidados',
            'gestionar finanzas',
            'gestionar insumos',

            // Cotizaciones
            'ver cotizaciones',         // Ver listado de cotizaciones
            'despachar cotizaciones',      // Crear una nueva cotización
            'editar cotizaciones',      // Editar una cotización existente
            'eliminar cotizaciones',    // Eliminar una cotización existente

        ];

        foreach ($permisos as $nombre) {
            Permission::firstOrCreate([
                'name' => $nombre,
                'guard_name' => 'web',
            ]);
        }

        // Crear rol admin si no existe
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Asignar todos los permisos al rol admin
        $admin->syncPermissions(Permission::all());
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
