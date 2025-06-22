<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable = ['title', 'type', 'start_date', 'end_date', 'producto_id'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}