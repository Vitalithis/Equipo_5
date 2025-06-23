<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlantTreatmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->words(2, true),
            'tipo' => $this->faker->randomElement(['Fertilizante', 'Fungicida', 'Insecticida', 'Herbicida', 'Acaricida', 'Otro']),
            'composicion' => $this->faker->sentence(),
            'descripcion' => $this->faker->paragraph(),
            'peso' => $this->faker->randomFloat(2, 0.1, 5),
            'unidad_medida' => $this->faker->randomElement(['kg', 'g', 'ml', 'L']),
            'presentacion' => $this->faker->randomElement(['Líquido', 'Polvo', 'Granulado']),
            'aplicacion' => $this->faker->sentence(),
            'frecuencia_aplicacion' => $this->faker->randomElement(['Diaria', 'Semanal', 'Mensual', 'Cada 15 días']),
            'precio' => $this->faker->numberBetween(1000, 20000),
            'stock' => $this->faker->numberBetween(10, 500),
            'fecha_vencimiento' => $this->faker->dateTimeBetween('+1 month', '+2 years'),
            'imagen' => null, // O usa 'default.png' si tienes imágenes por defecto
            'activo' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
