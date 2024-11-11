<x-app-layout>
    <div>
        <div class="main_header">
            <h3>Panorama Gral</h3>
            <img id="config" src="./assets/img/icons/config.png" alt="config">

            <div class="options_config">
                @foreach ($locations as $location)
                    <span id="ubicacion-{{ Str::slug($location->name) }}" data-ubicacion="{{ $location->name }}"
                        class="botton_option {{ request('ubicacion') == $location->name ? 'active' : '' }}"
                        onclick="setUbicacion('{{ $location->name }}')">
                        {{ $location->name }}
                    </span>
                @endforeach

                <span id="ubicacion-todos" data-ubicacion="Todos"
                    class="botton_option {{ request('ubicacion') == 'Todos' ? 'active' : '' }}"
                    onclick="setUbicacion('Todos')">
                    Todos
                </span>

                <!-- Campo oculto para enviar la ubicación -->
            </div>
        </div>

        <form action="{{ route('panorama_gral') }}" method="GET">
            <div class="options_conteiner">
                <div class="options date_start">
                    <img src="./assets/img/icons/calendar.png" alt="calendar">
                    <input type="text" id="date_start" name="date_start" placeholder="Fecha de inicio"
                        value="{{ request('date_start') }}">
                </div>
                <div class="options date_end">
                    <img src="./assets/img/icons/calendar.png" alt="calendar">
                    <input type="text" id="date_end" name="date_end" placeholder="Fecha de fin"
                        value="{{ request('date_end') }}">
                </div>
                <div class="options filter">
                    <button type="submit">Filtrar</button>
                </div>
            </div>
            <input type="hidden" name="ubicacion" id="ubicacion" value="{{ request('ubicacion', 'Todos') }}">

        </form>

        <section class="general_info">
            <div class="total_events">
                <p>Total de eventos</p>
                <div class="circle">
                    @if ($dateStart && $dateEnd)
                        {{ $events->count() ?: 0 }}
                    @else
                        0
                    @endif
                </div> <!-- Muestra 0 si no hay eventos o las fechas no están definidas -->
            </div>
        
            <div class="events_info">
                <div class="card_event_info">
                    <p>Capacidad total</p>
                    <div class="secondary_circles">
                        @if ($dateStart && $dateEnd)
                            {{ $events->sum('capacity') ?: 0 }} <!-- Muestra 0 si no hay capacidad de eventos filtrados -->
                        @else
                            0
                        @endif
                    </div>
                </div>
                <div class="card_event_info">
                    <p>Asientos vendidos</p>
                    <div class="secondary_circles">
                        @if ($dateStart && $dateEnd)
                            {{ ($events->sum('capacity') - $events->sum('remaining_capacity')) ?: 0 }} <!-- Muestra 0 si no hay asientos vendidos -->
                        @else
                            0
                        @endif
                    </div>
                </div>
                <div class="card_event_info">
                    <p>Asientos disponibles</p>
                    <div class="secondary_circles">
                        @if ($dateStart && $dateEnd)
                            {{ $events->sum('remaining_capacity') ?: 0 }} <!-- Muestra 0 si no hay asientos disponibles -->
                        @else
                            0
                        @endif
                    </div>
                </div>
            </div>
        
        </section>
        
        

        <section class="list_events">
            @if ($dateStart && $dateEnd)
                @if ($events->isEmpty())
                    <p>No se encontraron eventos para el rango de fechas seleccionado.</p>
                @else
                    @foreach ($events as $event)
                        <div class="event">
                            <!-- Convertimos el nombre del evento en un enlace -->
                            <a id="name_event" href="{{ url('detallesEvento', ['id' => $event->id]) }}">
                                {{ $event->name }}
                            </a>
                            <p id="date">
                                {{ \Carbon\Carbon::parse($event->event_date)->locale('es')->isoFormat('D MMMM YYYY') }}
                            </p>

                            @if ($event->space && $event->space->location)
                                <p id="place">{{ $event->space->location->name }}</p>
                            @else
                                <p id="place">Sin ubicación</p>
                            @endif
                        </div>
                    @endforeach
                @endif
            @else
                <p>Por favor, seleccione un rango de fechas para ver los eventos.</p>
            @endif
        </section>


        <div class="leyends">
            <!-- Sección para leyendas -->
        </div>
    </div>

    <script>
        function setUbicacion(ubicacion) {
            document.getElementById('ubicacion').value = ubicacion;
            // Actualizar la clase activa
            document.querySelectorAll('.botton_option').forEach(function(element) {
                element.classList.remove('active');
            });
            document.getElementById('ubicacion-' + ubicacion.replace(/\s+/g, '-').toLowerCase()).classList.add('active');
        }
    </script>

    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/peticiones.js') }}"></script>
</x-app-layout>
