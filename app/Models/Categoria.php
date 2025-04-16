<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = ['nombre'];

    public function producto()
    {
        return $this->belongsToMany(Producto::class, 'producto_categoria');
    }
}
