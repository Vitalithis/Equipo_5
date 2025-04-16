<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $categorias = ['Suculenta', 'Interior', 'Exterior', 'Medicinal', 'Árbol', 'Decorativa'];
        $dificultades = ['Fácil', 'Intermedio', 'Experto'];
        $ubicaciones = ['Interior', 'Exterior', 'Sol directo', 'Sombra'];
        $frecuencias = ['1 vez por semana', '2 veces por semana', 'Cada 15 días'];

        $categoria = Categoria::inRandomOrder()->first(); // Selecciona una categoría aleatoria existente

        return [
            'nombre' => $this->faker->unique()->words(2, true),
            'nombre_cientifico' => $this->faker->optional()->words(3, true),
            'descripcion' => $this->faker->sentence(12),
            'precio' => $this->faker->randomFloat(2, 2, 30),
            'stock' => $this->faker->numberBetween(0, 50),
            'categoria' => $this->faker->randomElement($categorias),
            'imagen' => 'https://placehold.co/640x480?text=' . urlencode($this->faker->word()),
            'codigo_barras' => $this->faker->unique()->ean13(),
            'cuidados' => $this->faker->sentence(15),
            'nivel_dificultad' => $this->faker->randomElement($dificultades),
            'frecuencia_riego' => $this->faker->randomElement($frecuencias),
            'ubicacion_ideal' => $this->faker->randomElement($ubicaciones),
            'beneficios' => $this->faker->sentence(10),
            'toxica' => $this->faker->boolean(20), // 20% probabilidad de ser tóxica
            'origen' => $this->faker->country(),
            'tamano' => $this->faker->randomElement(['Pequeña', 'Mediana', 'Grande']),
            'activo' => $this->faker->boolean(90),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($producto) {
            // Asociamos el producto con categorías aleatorias (mínimo 1)
            $categoriaIds = Categoria::inRandomOrder()->take(2)->pluck('id')->toArray(); // Selecciona hasta 2 categorías aleatorias
            $producto->categoria()->sync($categoriaIds); // Relaciona las categorías con el producto
        });
    }
}
