<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FixDuplicatePermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiar permisos duplicados (dejando los globales)
        $nombresDuplicados = Permission::select('name')
            ->groupBy('name')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('name');

        foreach ($nombresDuplicados as $nombre) {
            $global = Permission::where('name', $nombre)->whereNull('cliente_id')->first();

            // Borra los duplicados (que tengan cliente_id y no sean el global)
            Permission::where('name', $nombre)
                ->whereNotNull('cliente_id')
                ->where('id', '!=', optional($global)->id)
                ->delete();
        }

        // 2. Clonar permisos globales a los clientes que no los tengan
        $roles = Role::whereNotNull('cliente_id')->get();
        foreach ($roles as $role) {
            $cliente_id = $role->cliente_id;

            // Si el cliente no tiene permisos aún, los clonamos
            $existen = Permission::where('cliente_id', $cliente_id)->exists();
            if (!$existen) {
                $globales = Permission::whereNull('cliente_id')->get();
                foreach ($globales as $permiso) {
                    Permission::firstOrCreate([
                        'name' => $permiso->name,
                        'guard_name' => $permiso->guard_name,
                        'cliente_id' => $cliente_id,
                    ]);
                }
            }

            // 3. Asignar todos los permisos del cliente al rol admin
            $permisosCliente = Permission::where('cliente_id', $cliente_id)->get();
            $role->syncPermissions($permisosCliente);
        }

        $this->command->info("✅ Permisos corregidos y sincronizados para todos los roles con cliente.");
    }
}
