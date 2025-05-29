<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'slug', 'nombre', 'nombre_cientifico', 'descripcion',
        'precio', 'stock', 'imagen', 'cuidados', 'nivel_dificultad',
        'frecuencia_riego', 'ubicacion_ideal', 'beneficios', 'toxica',
        'origen', 'tamano', 'activo'
    ];

    protected $casts = [
        'precio' => 'float',
        'activo' => 'boolean',
    ];

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'producto_categoria');
    }

    public function getCategoriaAttribute()
    {
        return $this->categorias()->first()?->nombre;
    }

    public function descuentos()
    {
        return $this->belongsToMany(Descuento::class, 'descuento_producto')->withTimestamps();
    }

    // En App\Models\Producto.php
    public static function toma4ultimos()
    {
        return self::withoutGlobalScopes()
            ->latest()
            ->take(4)
            ->get();
    }
    public function fertilizaciones()
{
    return $this->hasMany(Fertilization::class);
}

}
