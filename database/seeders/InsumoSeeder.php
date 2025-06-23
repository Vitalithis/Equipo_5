<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Insumo;
use App\Models\InsumoDetalle;

class InsumoSeeder extends Seeder
{
    public function run(): void
    {
        $insumo = Insumo::first(); // Asegúrate de tener al menos un insumo creado

        if ($insumo) {
            $detalles = [
                [
                    'nombre' => 'Pala mango corto',
                    'cantidad' => 5,
                    'costo_unitario' => 2500,
                ],
                [
                    'nombre' => 'Pala mango largo',
                    'cantidad' => 3,
                    'costo_unitario' => 2800,
                ],
            ];

            foreach ($detalles as $detalle) {
                $insumo->detalles()->create($detalle);
            }
        }
    }
}
