<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Models\Cliente;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nombre' => 'Plantas Editha',
                'subdominio' => 'editha',
                'slug' => 'plantas-editha',
                'email' => 'admin@editha.com',
                'password' => 'editha',
            ],
        ];

        foreach ($clientes as $data) {
            // 1. Crear cliente
            $cliente = Cliente::firstOrCreate(
                ['nombre' => $data['nombre']],
                [
                    'subdominio' => $data['subdominio'],
                    'slug' => $data['slug'],
                    'activo' => true,
                ]
            );

            // 2. Crear rol admin único por cliente
            $rolAdmin = Role::updateOrCreate(
                ['name' => 'admin', 'cliente_id' => $cliente->id],
                ['guard_name' => 'web']
            );

            // 3. Crear rol user sin permisos
            $rolUser = Role::updateOrCreate(
                ['name' => 'user', 'cliente_id' => $cliente->id],
                ['guard_name' => 'web']
            );

            // 4. Clonar permisos globales (cliente_id null)
            $permisosGlobales = Permission::whereNull('cliente_id')->get();
            foreach ($permisosGlobales as $permiso) {
                $nuevo = Permission::firstOrCreate([
                    'name' => $permiso->name,
                    'guard_name' => 'web',
                    'cliente_id' => $cliente->id,
                ]);

                if (!$rolAdmin->hasPermissionTo($nuevo)) {
                    $rolAdmin->givePermissionTo($nuevo);
                }
            }

            // 5. Crear usuario admin
            $usuario = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => 'Admin ' . $data['nombre'],
                    'password' => Hash::make($data['password']),
                    'cliente_id' => $cliente->id,
                    'must_change_password' => true,
                ]
            );

            // 6. Evitar duplicado en model_has_roles
            $condicion = [
                'role_id' => $rolAdmin->id,
                'model_type' => User::class,
                'model_id' => $usuario->id,
                'cliente_id' => $cliente->id,
            ];

            DB::table('model_has_roles')->updateOrInsert(
                [
                    'role_id' => $rolAdmin->id,
                    'model_type' => User::class,
                    'model_id' => $usuario->id,
                ],
                ['cliente_id' => $cliente->id]
            );
        }

        $this->command->info("✅ Clientes, usuarios admin, roles admin/user y permisos creados correctamente.");
    }
}
