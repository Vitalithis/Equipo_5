<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'usuario_id',
        'fecha_pedido',
        'metodo_entrega',
        'direccion_entrega',
        'estado_pedido',         // este sí va
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
        'boleta_final_path'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}

