<x-app-layout>
    <div class="main_header">
        <h3>Ticket Gral</h3>
    </div>

    <div class="ticket">
        <div class="card_ticket">
            <div class="card_header">
                <img src="{{ asset('assets/img/Logos/logo_color.png') }}" alt="">
                <div class="number_ticket">#{{ $reservation->id }}</div> <!-- Número de ticket -->
            </div>

            <div class="card_body">
                <h3>{{ $reservation->event->name }}</h3> <!-- Nombre del evento -->

                <div class="row_ticket">
                    <p>Descripcion:</p>
                    <span>{{ $reservation->event->descripcion }}</span> <!-- Descripción del evento -->
                </div>

                <div class="row_ticket">
                    <p>Fecha evento:</p>
                    <span>{{ \Carbon\Carbon::parse($reservation->event->event_date)->format('Y-m-d') }}</span> <!-- Fecha del evento -->
                </div>

                <div class="row_ticket">
                    <p>Propiedad:</p>
                    <span>{{ $reservation->event->space->name }}</span> <!-- Propiedad (lugar) -->
                </div>

                <div class="row_ticket">
                    <p>Lugar:</p>
                    <span>{{ $reservation->table->table_number }}</span> <!-- Número de mesa -->
                </div>

                <h3>Detalles de la reservacion</h3>

                <div class="row_ticket">
                    <p>Nombre reservacion:</p>
                    <span>{{ $reservation->name }}</span> <!-- Nombre de la persona que hizo la reserva -->
                </div>

                <div class="row_ticket">
                    <p>Fecha reservacion</p>
                    <span>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') }}</span> <!-- Fecha de la reserva -->
                </div>

                <div class="row_ticket">
                    <p>Asientos reservados:</p>
                    <span>{{ $reservation->seats_reserved }}</span> <!-- Número de asientos reservados -->
                </div>

                <!-- Desglose de los asientos reservados -->
                <h3>Desglose del total</h3>
                <div class="row_ticket">
                    <p>Adultos:</p>
                    <span>{{ $adultos }} x {{ $event->precioAdulto }} = {{ $event->precioAdulto * $adultos }}</span>
                </div>
                <div class="row_ticket">
                    <p>Infantes:</p>
                    <span>{{ $infantes }} x {{ $event->precioInfante }} = {{ $event->precioInfante * $infantes }}</span>
                </div>
                <div class="row_ticket">
                    <p>Menores:</p>
                    <span>{{ $menores }} x {{ $event->precioMenor }} = {{ $event->precioMenor * $menores }}</span>
                </div>

                <div class="row_ticket">
                    <p>Total:</p>
                    <span>{{ number_format($total, 2, '.', ',') }} MXN</span> <!-- Total calculado con formato moneda -->


                </div>

            </div>

            <div class="info"></div>
        </div>

        <div class="download_ticket submit_button" onclick="downloadPDF()">
            Descargar
        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF() {
            const cardTicket = document.querySelector('.card_ticket');

            // Opciones para el PDF
            const options = {
                filename: `ticket_${new Date().toISOString().slice(0, 10)}.pdf`,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 1
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'legal',
                    orientation: 'portrait'
                },
            };

            // Generar PDF
            html2pdf()
                .set(options)
                .from(cardTicket)
                .save();
        }
    </script>


    <script>
        @if(isset($layout) && !empty($layout))
        // Si layout_json está disponible, parsear el JSON
        const layoutData = JSON.parse(`{!! $layout !!}`);
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
                const items = groupedElements[char];

                // Calcular las dimensiones y posición de la fusión
                const x = Math.min(...items.map(item => item.x));
                const y = Math.min(...items.map(item => item.y));
                const width = Math.max(...items.map(item => item.x + item.width)) - x;
                const height = Math.max(...items.map(item => item.y + item.height)) - y;

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
            console.log("label es ", label)
            // Verificar si el label es un elemento individual (tipo 'm') para hacerlo redondo
            if (label.charAt(0) == 'e' || label.charAt(0) == 'p') {
                // Estilos para rectángulos con label que empieza con "E"
                rectangle.style.backgroundColor = '#031227'; // Fondo de color oscuro
                rectangle.style.color = '#ffffff'; // Color del texto blanco
            } else if (type === 'individual') {
                rectangle.style.borderRadius = '50%'; // Hacerlo redondo
                rectangle.style.backgroundColor = '#17C02E'; // Color diferente para distinguir
            } else {
                rectangle.style.backgroundColor = 'rgba(0, 0, 255, 0.5)'; // Color del rectángulo agrupado
            }

            rectangle.innerText = label; // Agregar texto al rectángulo
            rectangle.classList.add('rectangle'); // Clase opcional para estilos

            // Agregar el evento de clic solo a los elementos de mesa
            if (type === 'individual') {
                rectangle.addEventListener('click', function() {
                    console.log(`Mesa seleccionada: ${label}`);
                    document.getElementById("mesaSelected").value = label

                });
            }

            // Agregar el rectángulo a la sección de información
            document.querySelector('.info').appendChild(rectangle);



        }
    </script>

</x-app-layout>