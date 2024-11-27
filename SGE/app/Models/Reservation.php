<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
     // Especificamos el nombre de la tabla (singular)
     protected $table = 'reservation';  // <-- Añadir esto

    protected $fillable = [
        'user_id',
        'event_id',
        'reservation_date',
        'table_id',
        'seats_reserved',
        'status',
        'name',
        'total'
    ];

    // Relación con la tabla 'tables'
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Relación con la tabla 'events'
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relación con la tabla 'seats'
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    // Relación con 'tickets' si es necesario
    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
}
