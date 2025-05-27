<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = [
        'nombre',
        'tipo_uso', // 'venta' o 'uso'
        'stock',
        'precio',
        'descripcion',
    ];
}
