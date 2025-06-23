<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoTransporte extends Model
{
    use HasFactory;

    protected $table = 'gastos_transporte'; // muy importante

    protected $fillable = [
        'fecha',
        'tipo_gasto',
        'transportista_nombre',
        'transportista_contacto',
        'vehiculo_descripcion',
        'monto',
        'detalle',
        'comprobante_path',
        'pagado',
    ];
}
