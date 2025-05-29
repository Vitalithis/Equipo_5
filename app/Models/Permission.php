<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Support\Facades\Auth;

class Permission extends SpatiePermission
{
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('tenant', function ($builder) {
            $clienteId = null;
            if (app()->bound('clienteActual')) {
                $clienteId = app('clienteActual')->id;
            }

            if ($clienteId) {
                $builder->where('roles.cliente_id', $clienteId);
            }
        });
    }

}
