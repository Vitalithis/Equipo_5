<?php

namespace Database\Factories;

use App\Models\GastoTransporte;
use Illuminate\Database\Eloquent\Factories\Factory;

class GastoTransporteFactory extends Factory
{
    protected $model = GastoTransporte::class;

    public function definition(): array
    {
        return [
            'fecha' => $this->faker->date(),
            'tipo_gasto' => $this->faker->randomElement(['movilizacion', 'reparto', 'retiro', 'flete']),
            'transportista_nombre' => $this->faker->name(),
            'transportista_contacto' => $this->faker->phoneNumber(),
            'vehiculo_descripcion' => $this->faker->word(),
            'monto' => $this->faker->randomFloat(0, 1000, 100000),
            'detalle' => $this->faker->sentence(),
            'comprobante_path' => null,
            'pagado' => $this->faker->boolean(),
        ];
    }
}
