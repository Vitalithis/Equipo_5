<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory  
{
    protected $model = Proveedor::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'telefono' => $this->faker->e164PhoneNumber,
            'direccion' => $this->faker->address,
            'empresa' => $this->faker->company,
            'tipo_proveedor' => $this->faker->randomElement(['Sustratos', 'Productos aplicables', 'Herramientas', 'Servicios Vivero', 'Construccion', 'Plantas', 'Arboles', 'Plasticos/Cerámicas', 'Plantines', 'Varios']),
            'estado' => $this->faker->randomElement(['Activo', 'Inactivo']),
            'notas' => $this->faker->sentence,
        ];
    }
}