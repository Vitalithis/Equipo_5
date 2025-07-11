<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{

    public static function tiposDisponibles()
{
    return [
        'Sustratos',
        'Productos aplicables',
        'Herramientas',
        'Servicios Vivero',
        'Construccion',
        'Plantas',
        'Arboles',
        'Plasticos/Cerámicas',
        'Plantines',
        'Varios',
    ];
}

    use HasFactory;
    protected $table = 'proveedores';  // Cambia 'proveedors' por 'proveedores'

    // Definir los campos que se pueden llenar
    protected $fillable = [
        'nombre',
        'empresa',
        'email',
        'telefono',
        'direccion',
        'tipo_proveedor',
        'estado',
        'notas',
    ];
}