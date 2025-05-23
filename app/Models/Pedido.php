<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'total',
        'estado_pedido',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'detalle_pedidos', 'pedido_id', 'producto_id')
                ->withPivot('cantidad', 'precio_unitario', 'subtotal', 'nombre_producto_snapshot', 'codigo_barras_snapshot', 'imagen_snapshot');
    }



    public static function estadosPorMetodo()
    {
        return [
            'domicilio' => [
                'pendiente' => 'Pendiente',
                'en_preparacion' => 'En preparación',
                'en_camino' => 'En camino',
                'enviado' => 'Enviado',
                'entregado' => 'Entregado',
            ],
            'retiro' => [
                'pendiente' => 'Pendiente',
                'en_preparacion' => 'En preparación',
                'listo_para_retiro' => 'Listo para retiro',
                'entregado' => 'Entregado',
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

