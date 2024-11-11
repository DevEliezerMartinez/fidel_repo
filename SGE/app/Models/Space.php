<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    // Relación con Location
    public function location()
    {
        return $this->belongsTo(Location::class, 'id_location'); // Aquí indicamos el nombre de la clave foránea
    }


    // Relación con Event
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
