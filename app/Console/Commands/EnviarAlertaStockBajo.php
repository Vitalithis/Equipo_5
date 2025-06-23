<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\StockBajo;
use Illuminate\Support\Facades\DB;

class EnviarAlertaStockBajo extends Command
{
    protected $signature = 'alerta:stockbajo';
    protected $description = 'Enviar correos de alerta por productos con stock bajo';

    public function handle()
    {
        $productos = Producto::where('stock', '<', 10)->get();

        if ($productos->isEmpty()) {
            $this->info('No hay productos con stock bajo.');
            return;
        }

        $usuarios = User::whereIn('id', function ($query) {
            $query->select('model_id')
                  ->from('model_has_roles')
                  ->whereIn('role_id', [1, 2]); // IDs de admin y soporte
        })->get();

        if ($usuarios->isEmpty()) {
            $this->warn('No hay usuarios con roles ID 1 o 2.');
            return;
        }

        foreach ($productos as $producto) {
            foreach ($usuarios as $usuario) {
                Mail::to($usuario->email)->send(new StockBajo($producto));
            }
        }

        $this->info('Correos de alerta enviados correctamente.');
    }
}
