<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';

    protected $fillable = [
        'slug',
        'nombre',
        'nombre_cientifico',
        'descripcion',
        'precio',
        'stock',
        'categoria',
        'imagen',
        'cuidados',
        'nivel_dificultad',
        'frecuencia_riego',
        'ubicacion_ideal',
        'beneficios',
        'toxica',
        'origen',
        'tamano',
        'activo',
    ];

    // Relación muchos a muchos con Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'producto_categoria');
    }
    protected $casts = [
    'precio' => 'integer',
];

    // Evento para asignar automáticamente el código de barras
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($producto) {
            $maxCodigoBarras = self::max('codigo_barras');
            $producto->codigo_barras = $maxCodigoBarras ? $maxCodigoBarras + 1 : 1;
        });
    }
}
