<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Barryvdh\DomPDF\Facade as PDF; // Necesitas instalar dompdf si no lo tienes aún

class TicketController extends Controller
{
    public function downloadTicket($id)
{
    $reservation = Reservation::with('event.space', 'table')->findOrFail($id);
    
    $adultos = $reservation->adultos; 
    $infantes = $reservation->infantes;
    $menores = $reservation->menores;
    $total = ($adultos * $reservation->event->precioAdulto) + ($infantes * $reservation->event->precioInfante) + ($menores * $reservation->event->precioMenor);

    $pdf = PDF::loadView('tickets.pdf', compact('reservation', 'adultos', 'infantes', 'menores', 'total'));
    
    return $pdf->download('ticket_'.$reservation->id.'.pdf');
}

}
