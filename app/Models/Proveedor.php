<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores'; // Asegura el nombre correcto

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
        'empresa',
        'tipo_proveedor',
        'estado',
        'notas',
    ];
}
