<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PlantTreatment extends Model
{
    use HasFactory;

    protected $table = 'plant_treatments';

    protected $fillable = [
        'nombre',
        'tipo',
        'composicion',
        'descripcion',
        'peso',
        'unidad_medida',
        'presentacion',
        'aplicacion',
        'precio',
        'stock',
        'fecha_vencimiento',
        'imagen',
        'activo',
        'frecuencia_aplicacion',
        'fabricante'
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'activo' => 'boolean',
    ];

    // Relación: 1 tratamiento tiene muchas aplicaciones
    public function aplicaciones()
    {
        return $this->hasMany(TreatmentApplication::class);
    }

    // Accesor opcional si quieres acceder a la última aplicación registrada
    public function ultimaAplicacion()
    {
        return $this->aplicaciones()->latest('fecha_aplicacion')->first();
    }

    // Accesor personalizado si quieres calcular próxima aplicación sin guardar en BD
    public function getProximaAplicacionAttribute()
    {
        $ultima = $this->ultimaAplicacion()?->fecha_aplicacion;

        if ($ultima && $this->frecuencia_aplicacion) {
            $dias = match (strtolower($this->frecuencia_aplicacion)) {
                'diaria' => 1,
                'cada 2 días', 'cada 2 dias' => 2,
                'semanal' => 7,
                'cada 10 días', 'cada 10 dias' => 10,
                'quincenal' => 15,
                'cada 20 días', 'cada 20 dias' => 20,
                'mensual' => 30,
                'bimestral' => 60,
                'cada 3 meses', 'trimestral' => 90,
                '2 veces al año', 'dos veces al año' => 180,
                'una vez al año', 'anual' => 365,
                default => null,
            };

            if ($dias) {
                return Carbon::parse($ultima)->addDays($dias);
            }
        }

        return null;
    }

}
