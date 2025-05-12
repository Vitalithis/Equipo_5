<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Descuento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'descuentos';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'porcentaje',
        'monto_fijo',
        'tipo',
        'valido_desde',
        'valido_hasta',
        'activo',
        'usos_maximos',
        'usos_actuales'
    ];

    protected $casts = [
        'valido_desde' => 'datetime',
        'valido_hasta' => 'datetime',
        'activo' => 'boolean',
        'porcentaje' => 'decimal:2',
        'monto_fijo' => 'decimal:2'
    ];

    // Tipos de descuento disponibles
    const TIPO_PORCENTAJE = 'porcentaje';
    const TIPO_MONTO_FIJO = 'monto_fijo';
    const TIPO_ENVIO_GRATIS = 'envio_gratis';

    /**
     * Relación con productos
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'descuento_producto')
                    ->withTimestamps();
    }

    /**
     * Relación con clientes
   * public function clientes()
   * {
   *     return $this->belongsToMany(Cliente::class, 'descuento_cliente')
   *                 ->withPivot('usado_en')
   *                 ->withTimestamps();
   * } pa despues
    */
    /**
     * Scope para descuentos activos
     */


}
