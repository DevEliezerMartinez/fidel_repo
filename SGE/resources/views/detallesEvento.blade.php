<x-app-layout>
    <div class="main_header">
        <h3>Panorama Gral</h3>
        <img id="config" src="{{ asset('assets/img/icons/config.png') }}" alt="config">

        <div class="options_config">
            <a href="" class="botton_option">Palacio mundo imperial</a>
            <a href="" class="botton_option">Princess mundo imperial</a>
        </div>
    </div>

    {{-- Si no hay información, muestra el div .no_info --}}
    @if (empty($eventInfo) || empty($eventInfo->fecha_inicio) || empty($eventInfo->fecha_fin))
        <div class="no_info">
            <img src="{{ asset('assets/img/icons/alert.png') }}" alt="alert">
            <p>Información no disponible</p>
            <span>El evento no tiene información para su reservación</span>
            <a href="{{ route('panorama_gral') }}">Regresar</a>
        </div>
    @else
        {{-- Si hay información, muestra el resto de la estructura --}}
        <form class="basic_info">
            <div class="sideform">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion">{{ $eventInfo->descripcion ?? '' }}</textarea>
            </div>

            <div class="right_form">
                <div class="options_conteiner">
                    <label for="fecha">Fecha</label>
                    <div class="options date_start">
                        <img src="{{ asset('assets/img/icons/calendar.png') }}" alt="calendar">
                        <input type="text" id="date_start" placeholder="Fecha de inicio" value="{{ $eventInfo->fecha_inicio ?? '' }}">
                    </div>
                    <div class="options date_end">
                        <img src="{{ asset('assets/img/icons/calendar.png') }}" alt="calendar">
                        <input type="text" id="date_end" placeholder="Fecha de fin" value="{{ $eventInfo->fecha_fin ?? '' }}">
                    </div>
                </div>

                <div class="lugar">
                    <label for="Lugar">Lugar:</label>
                    <select name="Lugar" id="Lugar">
                        <option value="Place">place1</option>
                        <option value="Place3">place2</option>
                        <option value="PlacE2">place3</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="infomesas">
            <p>Mesas vendidas</p>
            <span class="info_mesa vendidas">{{ $eventInfo->mesas_vendidas ?? '0' }}</span>
            <p>Mesas disponibles</p>
            <span class="info_mesa disponibles">{{ $eventInfo->mesas_disponibles ?? '10' }}</span>
        </div>

        <div class="details">
            <div class="info"></div>
            <div class="info_details">
                <div class="element">
                    <p>Capacidad total <span id="capacidad">{{ $eventInfo->capacidad ?? '0' }}</span></p>
                </div>
                <div class="element">
                    <p>Asientos vendidos total <span id="vendidos">{{ $eventInfo->asientos_vendidos ?? '0' }}</span></p>
                </div>
                <div class="element">
                    <p>Asientos disponibles <span id="disponibles">{{ $eventInfo->asientos_disponibles ?? '0' }}</span></p>
                </div>
            </div>
        </div>
    @endif

    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
</x-app-layout>
