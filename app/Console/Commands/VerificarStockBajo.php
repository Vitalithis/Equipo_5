<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\StockBajo;

class VerificarStockBajo extends Command
{
    protected $signature = 'alerta:stockbajo';

    protected $description = 'Envía correos si hay productos con stock menor a 10 para usuarios con rol Admin o Soporte';

    public function handle(): void
    {
        $productosBajoStock = Producto::where('stock', '<', 10)->get();

        if ($productosBajoStock->isEmpty()) {
            $this->info('No hay productos con stock bajo.');
            return;
        }

$usuarios = User::role(['admin', 'soporte'])->get();

        foreach ($productosBajoStock as $producto) {
            foreach ($usuarios as $usuario) {
                Mail::to($usuario->email)->send(new StockBajo($producto));
                $this->info("Enviado a {$usuario->email} por producto {$producto->nombre}");
            }
        }

        $this->info('Alertas de stock bajo enviadas.');
    }
}
