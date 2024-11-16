<x-app-layout>
    <div class="main_header">
        <h3>Layout del Evento</h3>
        <img src="{{ asset('assets/img/icons/config.png') }}" alt="config">

        <div class="options_config">
            <a href="" class="botton_option">Palacio mundo imperial</a>
            <a href="" class="botton_option">Princess mundo imperial</a>
        </div>
    </div>

    @if($layout)
    <!-- Mostrar layout del evento -->
    <div class="global_element">
        <div id="layout-container">
            <!--   <pre>{{ $layout->layout_json }}</pre> --> <!-- Muestra el JSON o úsalo para renderizar -->
        </div>

        <form class="basic_info">

            <div class="sideform">

                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" readonly>{{ $event->descripcion }}</textarea>
            </div>

            <div class="right_form">

                <div class="options_conteiner">
                    <label for="fecha">Fecha</label>
                    <div class="options date_start">
                        <img src="{{ asset('assets/img/icons/calendar.png') }}" alt="calendar">


                        <input type="text" id="date_start" value="{{ $event->event_date }}" readonly disabled>
                    </div>


                </div>

                <div class="lugar">

                    <label for="Lugar">Lugar:</label>
                    <select name="Lugar" id="Lugar" disabled>
                        @if ($event->space && $event->space->location)
                        <option value="{{ $event->space->location->id }}" selected>
                            {{ $event->space->location->name }}
                        </option>
                        @else
                        <option value="">Sin lugar asociado</option>
                        @endif
                    </select>
                </div>
            </div>






        </form>
        <div class="infomesas">
            <p>Mesas vendidas</p>
            <span class="info_mesa vendidas">0</span>
            <p>Mesas disponibles</p>
            <span class="info_mesa disponibles">10</span>
        </div>


        <div class="details">

            <div class="info"></div>


            <div class="info_details">
                <div class="element">
                    <p>Capacidad total <span id="capacidad">100</span> </p>
                </div>
                <div class="element">6
                    <p>Asientos vendidos total <span id="vendidos">16</span> </p>
                </div>
                <div class="element">
                    <p>Asientos disponibles <span id="disponibles">84</span> </p>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Mostrar mensaje de no información -->
    <div class="no_info">
        <img src="{{ asset('assets/img/icons/alert.png') }}" alt="alert">
        <p>Información no disponible</p>
        <span>El evento no tiene layout asociado.</span>
        <a href="{{ route('dashboard') }}">Regresar</a>
    </div>
    @endif

    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
</x-app-layout>