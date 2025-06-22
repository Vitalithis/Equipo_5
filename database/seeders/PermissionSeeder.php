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

        $permisos = collect([
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
            'gestionar infraestructura',
            'ver reportes',
            'gestionar tareas',
            'gestionar fertilizantes',
            'gestionar cuidados',
            'gestionar finanzas',
            'gestionar insumos',
            'gestionar cotizaciones',
            'ver panel soporte',
            'crear cliente',
            'gestionar clientes',
        ])->unique(); // 🔁 Elimina duplicados

        // Crear permisos GLOBALMENTE
        foreach ($permisos as $nombre) {
            Permission::firstOrCreate([
                'name' => $nombre,
                'guard_name' => 'web',
                'cliente_id' => null, // 🌐 GLOBAL
            ]);
        }

        // Crear rol soporte global
        $rolSoporte = Role::firstOrCreate([
            'name' => 'soporte',
            'guard_name' => 'web',
            'cliente_id' => null, // 🌐 GLOBAL
        ]);

        // Asignar todos los permisos al rol soporte
        $rolSoporte->syncPermissions(Permission::whereNull('cliente_id')->get());

        $this->command->info("✅ Permisos globales y rol 'soporte' creados correctamente.");
    }
}
