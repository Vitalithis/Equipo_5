<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ClienteScope;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $fillable = [
        'slug', 'nombre', 'nombre_cientifico', 'descripcion',
        'precio', 'stock', 'imagen', 'cuidados', 'nivel_dificultad',
        'frecuencia_riego', 'ubicacion_ideal', 'beneficios', 'toxica',
        'origen', 'tamano', 'activo', 'cliente_id'
    ];

    protected $casts = [
        'precio' => 'float',
        'activo' => 'boolean',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ClienteScope);

        static::creating(function ($producto) {
            if (app()->has('currentClienteId')) {
                $producto->cliente_id = app('currentClienteId');
            }
        });
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

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
}
