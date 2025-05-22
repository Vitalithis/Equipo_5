<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ClienteScope;

class ProductoCategoria extends Model
{
    protected $table = 'producto_categoria';

    protected $fillable = [
        'producto_id',
        'categoria_id',
        'cliente_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ClienteScope);

        static::creating(function ($pivot) {
            if (app()->has('currentClienteId')) {
                $pivot->cliente_id = app('currentClienteId');
            }
        });
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
