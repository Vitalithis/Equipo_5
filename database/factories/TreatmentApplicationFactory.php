<?php

namespace Database\Factories;

use App\Models\TreatmentApplication;
use App\Models\PlantTreatment;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class TreatmentApplicationFactory extends Factory
{
    protected $model = TreatmentApplication::class;

    public function definition(): array
    {
        $fechaAplicacion = $this->faker->dateTimeBetween('-1 year', 'now');
        $dias = [1, 2, 5, 7, 15, 30];
        $proximaAplicacion = (clone $fechaAplicacion)->modify('+' . $this->faker->randomElement($dias) . ' days');

        return [
            'plant_treatment_id' => PlantTreatment::factory(),
            'producto_id' => Producto::factory(),
            'fecha_aplicacion' => $fechaAplicacion->format('Y-m-d'),
            'dosis_aplicada' => $this->faker->randomElement(['5 ml/litro', '10 g/m²', '3 gotas/planta']),
            'proxima_aplicacion' => $this->faker->boolean(80) ? $proximaAplicacion->format('Y-m-d') : null,
            'notas' => $this->faker->optional()->sentence(),
        ];
    }
}
