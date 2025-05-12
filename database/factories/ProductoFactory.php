<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $dificultades = ['Fácil', 'Intermedio', 'Experto'];
        $ubicaciones = ['Interior', 'Exterior', 'Sol directo', 'Sombra'];
        $frecuencias = ['1 vez por semana', '2 veces por semana', 'Cada 15 días'];

        return [
            'nombre' => $this->generateProductName(),
            'slug' => $this->faker->unique()->slug(),
            'nombre_cientifico' => $this->faker->optional(70)->words(3, true),
            'descripcion' => $this->faker->paragraph(3),
            'precio' => $this->faker->randomFloat(2, 1.50, 99.99),
            'cantidad' => $this->faker->numberBetween(0, 100),
            'imagen' => $this->generateProductImage(),
            'codigo_barras' => $this->faker->unique()->ean13(),
            'cuidados' => $this->generateCareInstructions(),
            'nivel_dificultad' => $this->faker->randomElement($dificultades),
            'frecuencia_riego' => $this->faker->randomElement($frecuencias),
            'ubicacion_ideal' => $this->faker->randomElement($ubicaciones),
            'beneficios' => $this->generateBenefits(),
            'toxica' => $this->faker->boolean(20),
            'origen' => $this->faker->country(),
            'tamano' => $this->faker->numberBetween(5, 200), // En cm para más realismo
            'activo' => $this->faker->boolean(90),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($producto) {
            // Asegurar que existan categorías primero
            if (Categoria::count() === 0) {
                Categoria::factory()->count(6)->create();
            }

            // Asignar 1-3 categorías aleatorias
            $categoriaIds = Categoria::inRandomOrder()
                            ->take(rand(1, 3))
                            ->pluck('id')
                            ->toArray();

            $producto->categorias()->sync($categoriaIds);
        });
    }

    // Métodos auxiliares para generar datos más realistas
    private function generateProductName(): string
    {
        $types = ['Planta', 'Árbol', 'Arbusto', 'Cactus', 'Suculenta', 'Flor'];
        $colors = ['Verde', 'Roja', 'Amarilla', 'Multicolor', 'Blanca', 'Azul'];
        $features = ['Colgante', 'Decorativa', 'Perenne', 'Exótica', 'Rara'];

        return $this->faker->randomElement($types).' '.
               $this->faker->randomElement($colors).' '.
               $this->faker->randomElement($features);
    }

    private function generateProductImage(): string
    {
        $plantTypes = ['suculent', 'cactus', 'fern', 'palm', 'flower', 'bonsai'];
        return 'https://source.unsplash.com/random/640x480/?plant,'.$this->faker->randomElement($plantTypes);
    }

    private function generateCareInstructions(): string
    {
        $instructions = [
            'Requiere luz indirecta. Regar cuando el sustrato esté seco al tacto.',
            'Necesita abundante luz solar directa. Regar moderadamente.',
            'Mantener en sombra parcial. Humedad constante pero sin encharcar.',
            'Tolerante a la sequía. Regar escasamente cada 2-3 semanas.',
            'Prefiere ambientes húmedos. Pulverizar hojas regularmente.'
        ];

        return $this->faker->randomElement($instructions);
    }

    private function generateBenefits(): string
    {
        $benefits = [
            'Purifica el aire y mejora la calidad del ambiente.',
            'Ideal para decoración de interiores con estilo moderno.',
            'Ayuda a reducir el estrés y mejorar la concentración.',
            'Produce flores aromáticas que ambientan cualquier espacio.',
            'Perfecta para principiantes por su fácil cuidado.'
        ];

        return $this->faker->randomElement($benefits);
    }
}
