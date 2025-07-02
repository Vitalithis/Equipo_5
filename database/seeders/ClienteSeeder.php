<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = \App\Models\Cliente::all();

        foreach ($clientes as $cliente) {
            $rolAdmin = \Spatie\Permission\Models\Role::updateOrCreate(
                ['name' => 'admin', 'cliente_id' => $cliente->id],
                ['guard_name' => 'web']
            );

            $rolUser = \Spatie\Permission\Models\Role::updateOrCreate(
                ['name' => 'user', 'cliente_id' => $cliente->id],
                ['guard_name' => 'web']
            );
        }

        $this->command->info("✅ Roles admin/user creados para todos los clientes existentes.");
    }
}
