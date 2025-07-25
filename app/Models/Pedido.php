<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetallePedido;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'total',
        'fecha_pedido',
        'metodo_entrega',
        'direccion_entrega',
        'estado_pedido',
        'subtotal',
        'descuento',
        'impuesto',
        'total',
        'forma_pago',
        'estado_pago',
        'monto_pagado',
        'tipo_documento',
        'documento_generado',
        'observaciones',
        'boleta_final_path',
    ];

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

        public static function estadosTraducidos()
    {
        return [
            'pendiente' => 'Pendiente',
            'en_preparacion' => 'En preparación',
            'en_camino' => 'En camino',
            'enviado' => 'Enviado',
            'entregado' => 'Entregado',
            'listo_para_retiro' => 'Listo para retiro',
        ];
    }


    public function estadosPermitidos()
    {
        $mapa = self::estadosPorMetodo();
        return $mapa[$this->metodo_entrega] ?? [];
    }


    public function estadoFormateado()
    {
        $estados = self::estadosTraducidos();
        return $estados[$this->estado_pedido] ?? ucfirst(str_replace('_', ' ', $this->estado_pedido));
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }

    /**
     * Scope para pedidos pendientes de entrega
     */
    public function scopePendientesEntrega($query)
    {
        return $query->whereIn('estado_pedido', ['pendiente', 'en_preparacion']);
    }
}
