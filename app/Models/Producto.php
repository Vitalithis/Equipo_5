<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'nombre_cientifico',
        'descripcion',
        'precio',
        'stock',
        'categoria',
        'imagen',
        'codigo_barras',
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
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'productos_categorias');
    }
}
