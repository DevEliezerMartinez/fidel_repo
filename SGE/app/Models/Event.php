<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Especificamos la tabla si el nombre del modelo no coincide con el de la tabla
    protected $table = 'events';

    // Atributos que son asignables masivamente (para evitar el Mass Assignment)
    protected $fillable = [
        'space_id',
        'name',
        'event_date',
        'capacity',
        'remaining_capacity',
    ];

    // Atributos que deberían ser mutados (ej. fecha)
    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

}
