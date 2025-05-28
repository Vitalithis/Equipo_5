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
                'cantidad' => 100,
                'costo' => 2500,
                'descripcion' => 'Sustrato orgánico para maceteros y jardinería.',
            ],
            [
                'nombre' => 'Guano compostado',
                'cantidad' => 50,
                'costo' => 0,
                'descripcion' => 'Abono natural utilizado en cultivos internos del vivero.',
            ],
            [
                'nombre' => 'Macetero plástico 20cm',
                'cantidad' => 200,
                'costo' => 1200,
                'descripcion' => 'Macetero resistente para plantas medianas.',
            ],
            [
                'nombre' => 'Fertilizante líquido (uso interno)',
                'cantidad' => 80,
                'costo' => 0,
                'descripcion' => 'Fertilizante aplicado en producción interna del vivero.',
            ],
        ];

        foreach ($insumos as $insumo) {
            Insumo::create($insumo);
        }

        $this->command->info('✅ Insumos de ejemplo creados correctamente.');
    }
}
