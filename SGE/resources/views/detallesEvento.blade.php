<x-app-layout>
    <div class="main_header">
        <h3>Layout del Evento</h3>
        {{-- <img src="{{ asset('assets/img/icons/config.png') }}" alt="config"> --}}


    </div>

    @if (isset($layout)) <!-- Mostrar layout del evento -->
        <div class="global_element">
            <div id="layout-container">
                <!--   <pre>{{ $layout->layout_json }}</pre>  --><!-- Muestra el JSON o úsalo para renderizar -->
            </div>

            <form class="basic_info">

                <div class="sideform">

                    <label for="descripcion">Descripción:</label>
                    <input type="hidden" name="descripcion" id="descripcion" readonly disabled value="">
                    <span> {{ $event->descripcion }}</span>
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
                <span class="info_mesa vendidas">{{ $mesasVendidas }}</span>
                <p>Mesas disponibles</p>
                <span class="info_mesa disponibles">{{ $mesasDisponibles }}</span>
            </div>



            <div class="details">

                <div class="info"></div>


                <div class="info_details">
                    <div class="element">
                        <div class="element">
                            <p>Capacidad total: <span id="capacidad">{{ $capacidadTotal }}</span></p>
                        </div>
                        <div class="element">
                            <p>Asientos vendidos total: <span id="vendidos">{{ $vendidos }}</span></p>
                        </div>
                        <div class="element">
                            <p>Asientos disponibles: <span id="disponibles">{{ $disponibles }}</span></p>
                        </div>

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

    <script>
        // Verificar si $layout y $layout->layout_json están definidos antes de ejecutar JavaScript
        @if (isset($layout) && !empty($layout->layout_json))
            // Si layout_json está disponible, parsear el JSON
            const layoutData = JSON.parse(`{!! $layout->layout_json !!}`);
            renderConfig(layoutData); // Llamar a la función con los datos parseados
        @else
            // Si no hay datos, puedes manejar el caso aquí o mostrar un error
            console.warn('No hay datos de layout disponibles.');
        @endif

        function renderConfig(configData) {
            const groupedElements = {};

            // Agrupar elementos que empiezan con la misma letra (excepto 'm')
            configData.forEach((item) => {
                const firstChar = item.label?.charAt(0).toLowerCase(); // Obtener la primera letra

                // Verificar si el label es vacío o no existe
                if (!item.label || item.label.trim() === '') {
                    return; // No renderizar si el label está vacío
                }

                // Si es un elemento que empieza con 'm', dibujarlo individualmente
                if (firstChar === 'm') {
                    drawRectangle(item.x, item.y, item.width, item.height, item.label, 'individual');
                } else {
                    // Si el grupo no existe, crear uno nuevo
                    if (!groupedElements[firstChar]) {
                        groupedElements[firstChar] = [];
                    }
                    // Agregar el elemento al grupo correspondiente
                    groupedElements[firstChar].push(item);
                }
            });

            // Dibujar cada grupo de elementos (solo letras que no son 'm')
            for (const char in groupedElements) {
                // Obtener el primer elemento del grupo
                const firstItem = groupedElements[char][0];

                // Calcular las dimensiones y posición de la fusión
                const width = groupedElements[char].reduce((total, item) => total + item.width, 0);
                const height = Math.max(...groupedElements[char].map(item => item.height));
                const x = firstItem.x; // La posición x del primer elemento
                const y = firstItem.y; // La posición y del primer elemento

                // Definir el label basado en la inicial
                let displayLabel;
                switch (char) {
                    case 'e':
                        displayLabel = 'esc';
                        break;
                    case 'p':
                        displayLabel = 'pista';
                        break;
                    default:
                        displayLabel = char; // Por defecto muestra la letra
                }

                // Dibujar el rectángulo agrupado
                drawRectangle(x, y, width, height, displayLabel, 'grouped');
            }
        }

        // Modificar la función drawRectangle para manejar el label redondo
        function drawRectangle(x, y, width, height, label, type) {
            const rectangle = document.createElement('div');

            // Ajusta el tamaño de la cuadrícula
            const cellSize = 30; // Tamaño de cada celda

            // Establecer estilos CSS para posicionar el rectángulo
            rectangle.style.position = 'absolute';
            rectangle.style.left = `${x * cellSize}px`;
            rectangle.style.top = `${y * cellSize}px`;
            rectangle.style.width = `${width * cellSize}px`;
            rectangle.style.height = `${height * cellSize}px`;
            console.log("label es ",label)
            // Verificar si el label es un elemento individual (tipo 'm') para hacerlo redondo
            if (label.charAt(0) == 'e' || label.charAt(0)== 'p') {
                // Estilos para rectángulos con label que empieza con "E"
                rectangle.style.backgroundColor = '#031227'; // Fondo de color oscuro
                rectangle.style.color = '#ffffff'; // Color del texto blanco
            } else if (type === 'individual') {
                rectangle.style.borderRadius = '50%'; // Hacerlo redondo
                rectangle.style.backgroundColor = 'rgba(255, 0, 0, 0.5)'; // Color diferente para distinguir
            } else {
                rectangle.style.backgroundColor = 'rgba(0, 0, 255, 0.5)'; // Color del rectángulo agrupado
            }

            rectangle.innerText = label; // Agregar texto al rectángulo
            rectangle.classList.add('rectangle'); // Clase opcional para estilos

            // Agregar el evento de clic solo a los elementos de mesa
            if (type === 'individual') {
                rectangle.addEventListener('click', function() {
                    alert(`Mesa seleccionada: ${label}`); // Mostrar el label en un alert
                    // Redirigir con el evento y la mesa como parámetros
                    const eventId = window.location.pathname.split('/')[
                        2]; // Esto obtiene el ID del evento de la URL
                    console.log(eventId)
                    window.location.href = `reservacionEvento/${eventId}/${encodeURIComponent(label)}`;
                });
            }

            // Agregar el rectángulo a la sección de información
            document.querySelector('.info').appendChild(rectangle);
        }
    </script>
</x-app-layout>
