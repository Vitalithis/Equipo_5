<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\ClienteScope;

class DetallePedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id', 'producto_id', 'cantidad', 'precio_unitario',
        'subtotal', 'nombre_producto_snapshot', 'codigo_barras_snapshot',
        'imagen_snapshot', 'cliente_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ClienteScope);

        static::creating(function ($detalle) {
            if (app()->has('currentClienteId')) {
                $detalle->cliente_id = app('currentClienteId');
            }
        });
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
