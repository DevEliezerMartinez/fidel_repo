<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Definir la tabla asociada si no sigue la convención de pluralización
    protected $table = 'tickets';

    // Definir los campos que se pueden asignar de manera masiva (Mass Assignment)
    protected $fillable = [
        'reservation_id', // Relación con la reserva
        'ticket_pdf',     // Ruta o nombre del archivo PDF si se genera uno
    ];

    /**
     * Relación con la reserva.
     * Un ticket pertenece a una reserva.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
