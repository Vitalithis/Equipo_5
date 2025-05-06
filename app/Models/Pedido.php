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

    // app/Models/Pedido.php

    public static function estadosPorMetodo()
    {
        return [
            'envio_domicilio' => [
                'pendiente' => 'Pendiente',
                'en_preparacion' => 'En preparación',
                'en_camino' => 'En camino',
                'enviado' => 'Enviado',
                'entregado' => 'Entregado',
            ],
            'retiro_tienda' => [
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

}

