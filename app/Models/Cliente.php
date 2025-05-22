<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'slug'];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
