<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ClienteScope;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id', 'total', 'estado_pedido', 'cliente_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ClienteScope);

        static::creating(function ($pedido) {
            if (app()->has('currentClienteId')) {
                $pedido->cliente_id = app('currentClienteId');
            }
        });
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_pedidos')
                    ->withPivot('cantidad', 'precio_unitario', 'subtotal', 'nombre_producto_snapshot', 'codigo_barras_snapshot', 'imagen_snapshot');
    }

    public static function estadosPorMetodo()
    {
        return [
            'domicilio' => [
                'pendiente', 'en_preparacion', 'en_camino', 'enviado', 'entregado',
            ],
            'retiro' => [
                'pendiente', 'en_preparacion', 'listo_para_retiro', 'entregado',
            ],
        ];
    }

    public function estadosPermitidos()
    {
        $mapa = self::estadosPorMetodo();
        return $mapa[$this->metodo_entrega] ?? [];
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }
}
