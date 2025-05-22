<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Cliente;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Lista de permisos base para todos los clientes
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
            'ver panel soporte',
        ];

        // Crear los permisos globales (cliente_id = null)
        foreach ($permisos as $nombre) {
            Permission::firstOrCreate([
                'name' => $nombre,
                'guard_name' => 'web',
                'cliente_id' => null,
            ]);
        }

        // Obtener el cliente base (plantaseditha) si existe
        $cliente = Cliente::where('slug', 'plantaseditha')->first();

        if ($cliente) {
            // Clonar estos permisos solo si no están creados para este cliente
            $existen = Permission::where('cliente_id', $cliente->id)->exists();

            if (!$existen) {
                foreach ($permisos as $nombre) {
                    Permission::firstOrCreate([
                        'name' => $nombre,
                        'guard_name' => 'web',
                        'cliente_id' => $cliente->id,
                    ]);
                }
            }

            // Asignar los permisos al rol admin del cliente
            $admin = Role::where('name', 'admin')
                ->where('cliente_id', $cliente->id)
                ->first();

            if ($admin) {
                $permisosAsignables = Permission::where('cliente_id', $cliente->id)->get();
                $admin->syncPermissions($permisosAsignables);
                $this->command->info("✅ Permisos asignados al rol admin del cliente: {$cliente->nombre}");
            }
        }

        $this->command->info("✅ Permisos globales creados correctamente.");
    }
}
