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
        // Validación de los datos recibidos
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'event_id' => 'required|integer|exists:events,id',
            'reservation_date' => 'required|date',
            'table_id' => 'required|integer|exists:tables,id',
            'adultos' => 'required|integer|min:0',
            'infantes' => 'required|integer|min:0',
            'menores' => 'required|integer|min:0',
            'seats_reserved' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
        ]);

        // Verificar que la suma de personas coincida con los asientos reservados
        $totalPersonas = $validatedData['adultos'] + $validatedData['infantes'] + $validatedData['menores'];
        if ($totalPersonas !== $validatedData['seats_reserved']) {
            return response()->json([
                'success' => false,
                'message' => 'La suma de adultos, infantes y menores no coincide con el número de asientos reservados.',
            ], 422); // 422: Unprocessable Entity
        }

        // Crear la reserva
        $reservation = Reservation::create([
            'user_id' => $validatedData['user_id'],
            'event_id' => $validatedData['event_id'],
            'reservation_date' => $validatedData['reservation_date'],
            'table_id' => $validatedData['table_id'],
            'seats_reserved' => $validatedData['seats_reserved'],
            'status' => $validatedData['status'],
        ]);

        // Respuesta de éxito
        return response()->json([
            'success' => true,
            'message' => 'Reserva realizada con éxito.',
            'reservation' => $reservation, // Opcional: devolver los datos de la reserva
        ]);
    }
}
