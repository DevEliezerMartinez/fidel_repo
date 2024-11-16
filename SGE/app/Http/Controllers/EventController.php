<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventLayout;
use App\Models\Location;
use App\Models\Space;
use App\Models\User;
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




    public function showDetalles($eventId)
    {
        $event = Event::find($eventId);
        if ($event) {
            return response()->json(['event' => $event]);
        } else {
            return response()->json(['error' => 'Evento no encontrado'], 404);
        }
    }





    public function show($id)
    {
        // Buscar el evento por su ID con relaciones necesarias
        $event = Event::with('space.location')->findOrFail($id);

        // Verificar si el evento tiene un layout asociado
        $layout = EventLayout::where('event_id', $id)->first();

        // Pasar los datos del evento y layout a la vista
        return view('detallesEvento', compact('event', 'layout'));
    }





    public function sh1()
    {
        $users = User::all(); // O puedes usar alguna condición si deseas filtrar los usuarios

        // Pasar los usuarios a la vista
        return view('adminUsuarios', compact('users'));
    }

    public function sh2(Request $request)
    {
        // Obtener la ubicación seleccionada, por defecto será "Todos"
        $ubicacion = $request->input('ubicacion', 'Todos');

        // Inicializar la consulta
        $query = Event::query();

        // Filtrar por ubicación si está definida y no es "Todos"
        if ($ubicacion && $ubicacion !== 'Todos') {
            $query->whereHas('space.location', function ($query) use ($ubicacion) {
                $query->where('name', $ubicacion);
            });
        }

        // Obtener los eventos filtrados
        $events = $query->get(['id', 'name', 'event_date', 'space_id']);

        // Obtener las ubicaciones para el filtro
        $locations = Location::all();

        $spaces = Space::all();

        // Pasar los eventos, ubicaciones y filtros a la vista
        return view('adminEventos', compact('events', 'locations', 'spaces', 'ubicacion'));
    }


    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();

            return response()->json(['success' => 'Evento eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el evento'], 500);
        }
    }

    public function eventosMaster($id)
    {
        $event = Event::with('space')->findOrFail($id); // Traer el evento con su espacio relacionado
        $spaces = Space::all(); // Recuperar todos los espacios
        return view('eventosMaster', compact('event', 'spaces')); // Pasar tanto el evento como los espacios a la vista
    }





    // EventController.php
    public function store(Request $request)
    {
        try {
            // Validación de los campos
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'fecha' => 'required|date',
                'lugar' => 'required|string',
                'capacidad' => 'required|integer|min:1'
            ]);

            // Buscar la ubicación
            $space = Space::find($request->input('lugar'));

            if (!$space) {
                return response()->json(['error' => 'Ubicación no válida'], 400);
            }

            // Crear el evento
            $event = Event::create([
                'name' => $request->input('nombre'),
                'event_date' => $request->input('fecha'),
                'space_id' => $space->id,
                'capacity' => $request->input('capacidad'),
                'remaining_capacity' => $request->input('capacidad'),
            ]);

            return response()->json(['success' => 'Evento creado exitosamente', 'event' => $event]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura errores de validación y devuelve los detalles
            return response()->json(['error' => 'Errores de validación', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Captura otros errores y envía el mensaje completo
            return response()->json(['error' => 'Error inesperado', 'details' => $e->getMessage()], 500);
        }
    }

    public function updateInfo(Request $request, $eventId)
    {
        // Validación de los datos recibidos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'capacidad' => 'required|integer|min:1',
            'lugar' => 'required|exists:spaces,id', // Validar que el lugar exista en la tabla 'spaces'
            'configuraciones' => 'required|array', // Validar que la configuración sea un array
        ]);

        try {
            // Buscar el evento por su ID
            $event = Event::findOrFail($eventId);

            // Actualizar los datos del evento
            $event->name = $validatedData['nombre'];
            $event->event_date = $validatedData['fecha'];
            $event->descripcion = $validatedData['descripcion'];
            $event->capacity = $validatedData['capacidad'];
            $event->space_id = $validatedData['lugar'];

            // Guardar los cambios en la base de datos
            $event->save();

            // Guardar la configuración en la tabla event_layouts
            $layoutData = [
                'event_id' => $event->id,
                'layout_json' => json_encode($validatedData['configuraciones']),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insertar o actualizar la configuración en event_layouts
            EventLayout::updateOrCreate(
                ['event_id' => $event->id],
                $layoutData
            );

            return response()->json([
                'success' => 'Evento actualizado exitosamente y configuración guardada',
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'error' => 'Error al actualizar el evento',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function toggleStatus(Request $request, Event $event)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
        ]);

        try {
            $event->status = $validated['status'];
            $event->save();

            return response()->json(['success' => 'Estado del evento actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo actualizar el estado del evento.'], 500);
        }
    }
}
