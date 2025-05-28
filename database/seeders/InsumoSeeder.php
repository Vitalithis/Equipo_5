<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Insumo;

class InsumoSeeder extends Seeder
{
    public function run(): void
    {
        $insumos = [
            [
                'nombre' => 'Tierra de hoja',
                'tipo_uso' => 'venta',
                'stock' => 100,
                'precio' => 2500,
                'descripcion' => 'Sustrato orgánico para maceteros y jardinería.',
            ],
            [
                'nombre' => 'Guano compostado',
                'tipo_uso' => 'uso',
                'stock' => 50,
                'precio' => 0,
                'descripcion' => 'Abono natural utilizado en cultivos internos del vivero.',
            ],
            [
                'nombre' => 'Macetero plástico 20cm',
                'tipo_uso' => 'venta',
                'stock' => 200,
                'precio' => 1200,
                'descripcion' => 'Macetero resistente para plantas medianas.',
            ],
            [
                'nombre' => 'Fertilizante líquido (uso interno)',
                'tipo_uso' => 'uso',
                'stock' => 80,
                'precio' => 0,
                'descripcion' => 'Fertilizante aplicado en producción interna del vivero.',
            ],
        ];

        foreach ($insumos as $insumo) {
            Insumo::create($insumo);
        }

        $this->command->info('✅ Insumos de ejemplo creados correctamente.');
    }
}
