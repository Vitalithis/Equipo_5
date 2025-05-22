<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Scopes\ClienteScope;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = ['nombre', 'cliente_id'];

    protected static function booted()
    {
        static::addGlobalScope(new ClienteScope);

        static::creating(function ($categoria) {
            if (app()->has('currentClienteId')) {
                $categoria->cliente_id = app('currentClienteId');
            }
        });
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function producto()
    {
        return $this->belongsToMany(Producto::class, 'producto_categoria');
    }
}
