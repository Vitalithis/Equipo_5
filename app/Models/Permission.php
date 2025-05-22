<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Models\ClienteScope;

class Permission extends SpatiePermission
{
    protected static function booted()
    {
        static::addGlobalScope(new ClienteScope);
    }
}
