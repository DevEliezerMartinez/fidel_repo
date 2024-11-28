<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventLayout;
use App\Models\Location;
use App\Models\Seat;
use App\Models\Space;
use App\Models\Table;
use App\Models\User;
use Carbon\Carbon;  // Esto debe estar en la parte superior del archivo del controlador
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Obtener las fechas de inicio y fin del mes actual con horas
        $currentMonthStart = Carbon::now()->startOfMonth()->startOfDay()->format('Y-m-d H:i:s'); // 2024-11-01 00:00:00
        $currentMonthEnd = Carbon::now()->endOfMonth()->endOfDay()->format('Y-m-d H:i:s');       // 2024-11-30 23:59:59

        // Obtener las fechas del filtro o usar las del mes actual como predeterminado
        $dateStart = Carbon::parse($request->input('date_start', $currentMonthStart))->startOfDay()->format('Y-m-d H:i:s');
        $dateEnd = Carbon::parse($request->input('date_end', $currentMonthEnd))->endOfDay()->format('Y-m-d H:i:s');

        // Obtener la ubicación seleccionada, por defecto será "Todos"
        $ubicacion = $request->input('ubicacion', 'Todos');

        // Inicializar la consulta con las relaciones necesarias
        $query = Event::with(['space.location']); // Carga las relaciones space y location

        // Filtrar por fechas
        $query->whereBetween('event_date', [$dateStart, $dateEnd]);

        // Obtener el usuario actual
        $user = auth()->user();

        // Si el usuario tiene un `role_id` de 1, filtrar por la ubicación a la que pertenece
        if ($user->role_id == 1) {
            // Asumiendo que cada usuario tiene un campo `belonging_to_location` para asociar la ubicación
            $userLocationId = $user->belongs_to_location; // Cambia esto si el campo es otro

            $query->whereHas('space', function ($query) use ($userLocationId) {
                $query->where('id_location', $userLocationId);
            });
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



    public function reservacionEvento($eventId, $tableId)
    {
        // Eliminar todos los caracteres que no sean numéricos
        $tableId = preg_replace('/\D/', '', $tableId);

        $event = Event::findOrFail($eventId);

        $eventLayout = $event->layout; // Esto debería devolver el layout asociado


        // Obtener la mesa usando el event_layout_id
        $mesa = Table::where('event_layout_id', $eventLayout->id)
            ->where('table_number', $tableId) // Ahora buscamos por table_number
            ->firstOrFail();

        // Obtener las sillas asociadas a la mesa
        $sillas = $mesa->seats;

        // Contar asientos vendidos y disponibles
        $asientosVendidos = $sillas->where('is_reserved', 1)->count();
        $asientosDisponibles = $sillas->where('is_reserved', 0)->count();
        $totalAsientos = $sillas->count();

        // Pasar los datos a la vista
        return view('reservacionEvento', compact('event', 'mesa', 'sillas', 'asientosVendidos', 'totalAsientos', 'asientosDisponibles', 'tableId'));
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
        // Buscar el evento por su ID con las relaciones necesarias
        $event = Event::with('space.location')->findOrFail($id);

        // Verificar si el evento tiene un layout asociado
        $layout = $event->layout; // Asegúrate de que el modelo Event tiene la relación 'layout'

        if ($layout) {
            // Obtener todas las mesas asociadas al layout
            $tables = Table::where('event_layout_id', $layout->id)->get();

            // Calcular la capacidad total, asientos vendidos y disponibles
            $capacidadTotal = $tables->sum('total_seats');
            $vendidos = Seat::whereIn('table_id', $tables->pluck('id'))->where('is_reserved', 1)->count();
            $disponibles = Seat::whereIn('table_id', $tables->pluck('id'))->where('is_reserved', 0)->count();

            // Calcular las mesas vendidas y disponibles
            $mesasVendidas = $tables->filter(function ($table) {
                return Seat::where('table_id', $table->id)->where('is_reserved', 0)->count() === 0;
            })->count();

            $mesasDisponibles = $tables->count() - $mesasVendidas;

            // Obtener la información de los asientos para cada mesa
            foreach ($tables as $table) {
                // Agregar la propiedad 'all_seats_reserved' a cada mesa
                $table->all_seats_reserved = Seat::where('table_id', $table->id)
                    ->where('is_reserved', 1)
                    ->count() === $table->total_seats;
            }

            // Pasar los datos a la vista con las variables calculadas
            return view('detallesEvento', compact(
                'event',
                'layout',
                'tables',
                'capacidadTotal',
                'vendidos',
                'disponibles',
                'mesasVendidas',
                'mesasDisponibles'
            ));
        }

        // Si no hay layout, cargar la vista con solo el evento
        return view('detallesEvento', compact('event'));
    }









    public function sh1()
    {
        $users = User::with('location')->get();

        // Verificar si el usuario tiene rol 1 (administrador o similar)
        if (auth()->user()->role_id == 1) {
            return redirect()->route('dashboard'); // Redirige al dashboard si el rol es 1
        }

        // Pasar los usuarios a la vista
        return view('adminUsuarios', compact('users'));
    }

    public function sh2(Request $request)
    {

        // Verificar si el usuario tiene rol 1 (administrador o similar)
        if (auth()->user()->role_id == 1 || auth()->user()->role_id ==2) {
            return redirect()->route('dashboard'); // Redirige al dashboard si el rol es 1
        }

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

        // Obtener los eventos filtrados, incluyendo el campo `status`
        $events = $query->get(['id', 'name', 'event_date', 'space_id', 'status']);

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
        $event = Event::with('space', 'layout')->findOrFail($id); // Incluye 'layout' en las relaciones cargadas

        // Verifica si el evento tiene un layout
        if ($event->layout) {
            // Mostrar la vista 'eventosMaster' en lugar de redirigir
            $spaces = Space::all(); // Recuperar todos los espacios
            // Pasar también el layout a la vista
            $layout = $event->layout;
            return view('eventosMaster', compact('event', 'spaces', 'layout')); // Incluye el layout en la vista
        }

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
                /* 'color_s' => 'required|string|max:255', // Validación para el color */
                'lugar' => 'required|string',
                'capacidad' => 'required|integer|min:1'
            ]);

            // Buscar la ubicación (location)
            $loc = Location::find($request->input('lugar'));

            if (!$loc) {
                return response()->json(['error' => 'Ubicación no válida'], 400);
            }

            // Crear el evento, ahora con color
            $event = Event::create([
                'name' => $request->input('nombre'),
                'event_date' => $request->input('fecha'),
                'space_id' => $loc->id,
                'capacity' => $request->input('capacidad'),
                'remaining_capacity' => $request->input('capacidad'),
                /* 'color' => $request->input('color_s'), // Asegúrate de asignar el color aquí */
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
        try {
            // Obtener el valor de `to_edit_input` del request y convertirlo en booleano
            $toEdit = $request->input('to_edit_input') === 'true';

            // Configurar reglas de validación dinámicas según el valor de `to_edit`
            $rules = [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string|max:255',
                'fecha' => 'required|date',
                'lugar' => 'required|exists:spaces,id',
                'precioAdulto' => 'required|integer',
                'precioMenor' => 'required|integer',
                'precioInfante' => 'required|integer',
            ];

            // Si `toEdit` es falso, agregar validaciones para campos adicionales
            if (!$toEdit) {
                $rules = array_merge($rules, [
                    'capacidad' => 'required|integer|min:1',
                    'configuraciones' => 'required',
                    'mesasCantidad' => 'required|integer|min:1',
                    'sillasxmesa' => 'required|integer|min:1',
                ]);
            }

            // Validar los datos recibidos
            $validatedData = $request->validate($rules);

            // Buscar el evento por su ID
            $event = Event::findOrFail($eventId);

            // Variables para rastrear el estado de operaciones
            $isNewLayout = false;
            $newTablesCount = 0;
            $newSeatsCount = 0;

            // Actualizar los campos básicos siempre
            $event->name = $validatedData['nombre'];
            $event->descripcion = $validatedData['descripcion'];
            $event->event_date = $validatedData['fecha'];
            $event->space_id = $validatedData['lugar'];
            $event->precioAdulto = $validatedData['precioAdulto'];
            $event->precioMenor = $validatedData['precioMenor'];
            $event->precioInfante = $validatedData['precioInfante'];

            // Si `toEdit` es falso, actualizar campos adicionales
            if (!$toEdit) {
                $event->capacity = $validatedData['capacidad'];
                $event->remaining_capacity = $validatedData['capacidad'];

                // Guardar configuración en `event_layouts`
                $layout = EventLayout::updateOrCreate(
                    ['event_id' => $event->id],
                    [
                        'layout_json' => $validatedData['configuraciones'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                // Determinar si el layout fue creado o actualizado
                $isNewLayout = $layout->wasRecentlyCreated;

                // Crear mesas y sillas
                $mesasCantidad = $validatedData['mesasCantidad'];
                $sillasPorMesa = $validatedData['sillasxmesa'];

                for ($i = 1; $i <= $mesasCantidad; $i++) {
                    // Crear o actualizar la mesa
                    $table = Table::updateOrCreate(
                        ['event_layout_id' => $layout->id, 'table_number' => $i],
                        [
                            'total_seats' => $sillasPorMesa,
                            'available_seats' => $sillasPorMesa,
                        ]
                    );

                    // Contar nuevas mesas
                    if ($table->wasRecentlyCreated) {
                        $newTablesCount++;
                    }

                    // Crear o actualizar las sillas para la mesa
                    for ($j = 1; $j <= $sillasPorMesa; $j++) {
                        $seat = Seat::updateOrCreate(
                            ['table_id' => $table->id, 'seat_number' => $j],
                            ['is_reserved' => 0]
                        );

                        // Contar nuevas sillas
                        if ($seat->wasRecentlyCreated) {
                            $newSeatsCount++;
                        }
                    }
                }
            }

            // Guardar los cambios del evento
            $event->save();

            return response()->json([
                'success' => 'Evento actualizado exitosamente',
                'layout' => $isNewLayout ? 'nuevo' : 'actualizado',
                'mesas' => $newTablesCount > 0 ? "{$newTablesCount} mesas nuevas" : 'Mesas actualizadas',
                'sillas' => $newSeatsCount > 0 ? "{$newSeatsCount} sillas nuevas" : 'Sillas actualizadas',
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
