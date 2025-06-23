<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'plant_treatment_id',
        'producto_id',
        'fecha_aplicacion',
        'dosis_aplicada',
        'proxima_aplicacion',
        'notas',
    ];

    public function tratamiento()
    {
        return $this->belongsTo(PlantTreatment::class, 'plant_treatment_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function treatment()
    {
        return $this->belongsTo(PlantTreatment::class, 'plant_treatment_id');
    }


}
