<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = [
        'nombre',
        'cantidad',
        'costo',
        'descripcion',
    ];

    public function detalles()
{
    return $this->hasMany(InsumoDetalle::class);
}

}
