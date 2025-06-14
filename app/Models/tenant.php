<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Models\Domain;

class Tenant extends BaseTenant
{
    protected $fillable = ['id', 'data'];

    protected $casts = [
        'data' => 'array', // Laravel hará JSON encode/decode automático
    ];

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    // Accesor para nombre
    public function getNombreAttribute()
    {
        return $this->data['nombre'] ?? null;
    }

    // Accesor para activo
    public function getActivoAttribute()
    {
        return $this->data['activo'] ?? false;
    }
}
