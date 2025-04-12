<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoCategoria extends Model
{
    protected $table = 'productos_categorias';

    protected $fillable = [
        'producto_id',
        'categoria_id',
    ];
}
