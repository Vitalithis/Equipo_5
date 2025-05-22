<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\ClienteScope;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'producto_id', 'cantidad', 'precio_unitario', 'cliente_id'];

    protected static function booted()
    {
        static::addGlobalScope(new ClienteScope);

        static::creating(function ($item) {
            if (app()->has('currentClienteId')) {
                $item->cliente_id = app('currentClienteId');
            }
        });
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
