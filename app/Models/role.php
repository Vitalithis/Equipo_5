<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use App\Models\ClienteScope;

class Role extends SpatieRole
{
    protected static function booted()
    {
        static::addGlobalScope(new ClienteScope);
    }
}
