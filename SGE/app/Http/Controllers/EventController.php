<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Location;
use Carbon\Carbon;  // Esto debe estar en la parte superior del archivo del controlador
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Obtener la ubicación seleccionada, por defecto será "Todos"
        $ubicacion = $request->input('ubicacion', 'Todos');

        // Obtener las fechas de inicio y fin
        $dateStart = $request->input('date_start');
        $dateEnd = $request->input('date_end');

        // Inicializar la consulta
        $query = Event::query();

        // Filtrar por fechas si están definidas
        if ($dateStart && $dateEnd) {
            $query->whereBetween('event_date', [$dateStart, $dateEnd]);
        }

        // Filtrar por ubicación si está definida y no es "Todos"
        if ($ubicacion && $ubicacion !== 'Todos') {
            $query->whereHas('space.location', function ($query) use ($ubicacion) {
                $query->where('name', $ubicacion);
            });
        }

        // Obtener los eventos filtrados
        $events = $query->get(['id', 'name', 'event_date', 'capacity', 'remaining_capacity', 'space_id']);

        // Obtener las ubicaciones para el filtro
        $locations = Location::all();

        // Pasar los eventos, ubicaciones y filtros a la vista
        return view('panorama_gral', compact('events', 'locations', 'dateStart', 'dateEnd', 'ubicacion'));
    }





    public function show($id)
    {
        // Buscar el evento por su ID
        $event = Event::with('space.location')->findOrFail($id);

        // Retornar la vista con los detalles del evento
        return view('detallesEvento', compact('event'));
    }


    public function sh1() {
        return view('adminUsuarios');
    }

    public function sh2() {
        return view('adminEventos');
    }



}
