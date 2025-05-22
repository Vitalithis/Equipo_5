<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ClienteScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Aquí metés el filtro cliente_id que quieras
        if (auth()->check()) {
            $builder->where('cliente_id', auth()->user()->cliente_id);
        }
    }
} 