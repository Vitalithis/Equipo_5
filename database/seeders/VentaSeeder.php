<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VentaSeeder extends Seeder
{
    public function run()
    {
        $cliente = Cliente::where('slug', 'plantaseditha')->first();

        if (!$cliente) {
            $this->command->warn('Cliente plantaseditha no encontrado. Ejecuta ClienteSeeder primero.');
            return;
        }

        // Obtener un usuario del cliente
        $user = User::where('cliente_id', $cliente->id)->first();
        $producto = Producto::where('cliente_id', $cliente->id)->first();

        if (!$user || !$producto) {
            $this->command->warn('No hay usuario o producto para el cliente plantaseditha.');
            return;
        }

        DB::table('ventas')->insert([
            [
                'user_id' => $user->id,
                'producto_id' => $producto->id,
                'cantidad' => 3,
                'precio_unitario' => $producto->precio,
                'cliente_id' => $cliente->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('Venta creada para cliente: ' . $cliente->nombre);
    }
}
