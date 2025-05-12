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
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para descuentos válidos (fechas y usos)
     */
    public function scopeValidos($query)
    {
        $now = Carbon::now();

        return $query->where(function($q) use ($now) {
                $q->whereNull('valido_desde')->orWhere('valido_desde', '<=', $now);
            })
            ->where(function($q) use ($now) {
                $q->whereNull('valido_hasta')->orWhere('valido_hasta', '>=', $now);
            })
            ->where(function($q) {
                $q->whereNull('usos_maximos')
                ->orWhereRaw('usos_actuales < usos_maximos');
            });
    }

    /**
     * Verifica si el descuento es aplicable
     */
    public function esAplicable(): bool
    {
        $now = Carbon::now();

        // Verificar estado activo
        if (!$this->activo) {
            return false;
        }

        // Verificar fechas de validez
        if ($this->valido_desde && $this->valido_desde->gt($now)) {
            return false;
        }

        if ($this->valido_hasta && $this->valido_hasta->lt($now)) {
            return false;
        }

        // Verificar límite de usos
        if ($this->usos_maximos && $this->usos_actuales >= $this->usos_maximos) {
            return false;
        }

        return true;
    }

    /**
     * Aplica el descuento a un monto dado
     */
    public function aplicarDescuento(float $montoOriginal): float
    {
        if (!$this->esAplicable()) {
            return $montoOriginal;
        }

        return match ($this->tipo) {
            self::TIPO_PORCENTAJE => $montoOriginal * (1 - ($this->porcentaje / 100)),
            self::TIPO_MONTO_FIJO => max(0, $montoOriginal - $this->monto_fijo),
            self::TIPO_ENVIO_GRATIS => $montoOriginal,
            default => $montoOriginal,
        };
    }

    /**
     * Incrementa el contador de usos
     */
    public function registrarUso(): bool
    {
        if ($this->usos_maximos && $this->usos_actuales >= $this->usos_maximos) {
            return false;
        }

        $this->increment('usos_actuales');
        return true;
    }

}
