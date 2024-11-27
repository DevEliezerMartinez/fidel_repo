<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservaController extends Controller
{
    /**
     * Maneja la reserva.
     */
    public function reservar(Request $request)
    {
        try {
            // Validación de los datos recibidos
            $validatedData = $request->validate([
                'event_id' => 'required|integer|exists:events,id',
                'reservation_date' => 'required|date',
                'table_number' => 'required|integer',
                'adultos' => 'required|integer|min:0',
                'infantes' => 'required|integer|min:0',
                'menores' => 'required|integer|min:0',
                'seats_reserved' => 'required|string', // Validamos que sea un string en formato "1-2-3"
                'asientos' => 'required|integer',
                'name' => 'required|string', // Corregido de 'name' a 'string'
            ]);

            // Verificar que la suma de personas coincida con los asientos reservados
            $totalPersonas = $validatedData['adultos'] + $validatedData['infantes'] + $validatedData['menores'];
            if ($totalPersonas !== $validatedData['asientos']) {
                return response()->json([
                    'success' => false,
                    'message' => 'La suma de adultos, infantes y menores no coincide con el número de asientos reservados.',
                ], 422);
            }

            // Obtener el evento para obtener los precios de los asientos
            $event = \App\Models\Event::findOrFail($validatedData['event_id']);

            // Calcular el total
            $total = 0;
            $total += $event->precioAdulto * $validatedData['adultos'];
            $total += $event->precioInfante * $validatedData['infantes'];
            $total += $event->precioMenor * $validatedData['menores'];

            // Obtener el ID de la mesa (table_id) basado en el evento y el número de mesa
            $table = \App\Models\Table::where('event_layout_id', function ($query) use ($validatedData) {
                $query->select('id')
                    ->from('event_layouts')
                    ->where('event_id', $validatedData['event_id'])
                    ->limit(1);
            })->where('table_number', $validatedData['table_number'])
                ->first();

            // Validar que la mesa exista
            if (!$table) {
                return response()->json([
                    'success' => false,
                    'message' => 'El número de mesa especificado no es válido para este evento.',
                ], 422);
            }

            // Obtener el ID del usuario autenticado
            $userId = auth()->id();

            // Convertir `seats_reserved` en un array de números
            $seatNumbers = explode('-', $validatedData['seats_reserved']);

            // Actualizar los asientos reservados
            \App\Models\Seat::where('table_id', $table->id)
                ->whereIn('seat_number', $seatNumbers)
                ->update(['is_reserved' => 1]);

            // Crear la reserva y almacenar el total
            $reservation = Reservation::create([
                'user_id' => $userId,  // Usamos el ID del usuario logueado
                'event_id' => $validatedData['event_id'],
                'reservation_date' => $validatedData['reservation_date'],
                'table_id' => $table->id,  // Usamos el ID de la mesa obtenida
                'seats_reserved' => $validatedData['seats_reserved'],
                'status' => 1,
                'name' => $validatedData['name'],
                'total' => $total,  // Guardamos el total calculado
            ]);

            // Crear el ticket (en este caso, guardando null o generando un ticket_pdf si es necesario)
            $ticketPdf = null; // Aquí podrías generar un PDF si es necesario usando alguna librería como DomPDF.

            // Guardar el ticket relacionado con la reserva
            $ticket = \App\Models\Ticket::create([
                'reservation_id' => $reservation->id,
                'ticket_pdf' => $ticketPdf,  // Guardar el archivo PDF si es necesario, o NULL
            ]);

            // Respuesta de éxito
            return response()->json([
                'success' => true,
                'message' => 'Reserva realizada con éxito.',
                'reservation' => $reservation,
            ]);
        } catch (\Exception $e) {
            // Manejo de excepciones generales
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al procesar la reserva. Inténtalo más tarde.',
                'error' => $e->getMessage(),
            ], 500); // Código 500 para errores internos del servidor
        }
    }


    public function showTicket($id)
    {
        // Obtener la reserva por ID
        $reservation = Reservation::with(['table', 'event']) // Incluye las relaciones con 'table' y 'event'
            ->findOrFail($id);  // Si no se encuentra la reserva, lanzará una excepción

        // Obtener los detalles de los precios de los asientos
        $event = $reservation->event;

        // Obtener el desglose de los asientos reservados
        $adultos = $reservation->adultos; // Asume que estos campos se guardaron en la base de datos
        $infantes = $reservation->infantes;
        $menores = $reservation->menores;

        // Calcular el total
        $total = ($event->precioAdulto * $adultos) +
            ($event->precioInfante * $infantes) +
            ($event->precioMenor * $menores);

        // Retornar la vista con la información de la reserva y el desglose de costos
        return view('ticket', compact('reservation', 'total', 'adultos', 'infantes', 'menores', 'event'));
    }
}
