<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
    public function run(): void
    {
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
            'gestionar transporte',
                        'gestionar tratamientos',

            // Pedidos y descuentos

            'gestionar pedidos',
            'gestionar descuentos',

            'gestionar descuentos',    // <-- Usado para sección descuentos

            // Proveedores ✅ AÑADIDO
            'gestionar proveedores',

            // Mantenimiento Infrastructura // listado de arreglos que se hacen, tienen que tener, titulo, costo, fecha, descripcion
            'gestionar infraestructura',
            // Reportes

            'ver reportes',
            'gestionar tareas',
            'gestionar fertilizantes',
            'gestionar tratamientos',
            'gestionar cuidados',
            'gestionar finanzas',
            'gestionar insumos',

            // Cotizaciones
            'gestionar cotizaciones',       
           

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
            
        'ver dashboard',
        'gestionar usuarios',
        'gestionar roles',
        'gestionar permisos',
        'ver reportes',
        'gestionar productos',
        'gestionar clientes',
        'gestionar pedidos',
        'gestionar fertilizantes',
        'gestionar insumos',
        'gestionar trabajadores',
        'ver calendario',
        // Permisos adicionales para que el sidebar funcione
        'ver panel soporte',
        'gestionar catálogo',
        'ver roles',
        'gestionar descuentos',
        'gestionar tareas',
        'gestionar proveedores',
        'gestionar cuidados',
        'gestionar finanzas',
        'ver mantenimiento',
        'crear roles',
        'editar roles',
        'eliminar roles',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate([
                'name' => $permiso,
                'guard_name' => 'web',
                'cliente_id' => null, // 👈 importante
            ]);
        }

        // Crear rol soporte si no existe
        $rolSoporte = Role::firstOrCreate([
            'name' => 'soporte',
            'guard_name' => 'web',
        ]);

        // Asignar permisos del soporte
        $rolSoporte->syncPermissions([
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
            'gestionar transporte',
            // Pedidos y descuentos

            //transporte y tratamientos

            'gestionar tratamientos',

            'gestionar pedidos',
            'gestionar descuentos',

            'gestionar descuentos',    // <-- Usado para sección descuentos

            // Proveedores ✅ AÑADIDO
            'gestionar proveedores',

            // Mantenimiento Infrastructura // listado de arreglos que se hacen, tienen que tener, titulo, costo, fecha, descripcion
            'gestionar infraestructura',
            // Reportes

            'ver reportes',
            'gestionar tareas',
            'gestionar fertilizantes',
            'gestionar cuidados',
            'gestionar finanzas',
            'gestionar insumos',
            'gestionar tratamientos',

            // Cotizaciones
            'gestionar cotizaciones',       
           

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


        ]);

        $this->command->info("Permisos y rol soporte creados correctamente.");
    }
}
