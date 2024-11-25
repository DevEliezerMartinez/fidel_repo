<x-app-layout>

    <h2>Evento: {{ $event->name }}</h2>

    <form class="basic_info">

        <div class="sideform">
            <label for="descripcion">Descripción</label>
            <input type="hidden" name="descripcion" id="descripcion" readonly disabled value="">
            <span> {{ $event->descripcion }}</span>
        </div>

        <div class="right_form">
            <div class="options_conteiner">
                <label for="fecha">Fecha</label>
                <div class="options date_start">
                    <img src="{{ asset('assets/img/icons/calendar.png') }}" alt="calendar">
                    <input type="text" id="date_start" value="{{ old('date_end', $event->event_date) }}" readonly>
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
        <p>Asientos vendidos</p>
        <span class="info_mesa vendidas">{{ $asientosVendidos }}</span>

        <p>Asientos disponibles</p>
        <span class="info_mesa disponibles">{{ $asientosDisponibles }}</span>

        <div class="tiempo">
            <p>Tiempo</p>
            <div class="time" id="timer">
                <img src="{{ asset('assets/img/icons/Clock.png') }}" alt="clock"> 05:00

            </div>
        </div>
    </div>

    <div class="details">
        <div class="detailsMesa">
            <div class="mainMesa">{{ $tableId }}</div>
        </div>

        <form class="info_details">
            <h4>Detalles de la reservacion</h4>

            <div class="detailsReservacion">
                <p>No. de mesa</p>
                <input type="text" name="mesaNumber" id="mesaNumber" value="{{ $tableId }}" readonly>
                <input type="hidden" name="sillasNumber" id="sillasNumber" value="{{ $totalAsientos }}" readonly>
            </div>
            <div class="detailsReservacion">
                <p>Fecha de reservacion</p>
                <input type="date" name="fechaReservacion" id="fechaReservacion">
            </div>
            <div class="detailsReservacion">
                <p>Nombre de la reservacion</p>
                <input type="text" name="name" id="name" placeholder="Inserte el nombre de quien reserva">
            </div>

            <div class="detailsReservacion">
                <p>No. de asientos</p>
                <input type="number" name="asientos" id="asientos" readonly>
            </div>

            <input type="text" name="asientosSeleccionados" id="asientosSeleccionados">

            <div class="detailsPersona">
                <div class="detail">
                    <p>Adultos</p>
                    <input type="number" name="adultos" id="adultos">
                </div>
                <div class="detail">
                    <p>Infantes</p>
                    <input type="number" name="infantes" id="infantes">

                </div>
                <div class="detail">
                    <p>Menores</p>
                    <input type="number" name="menores" id="menores">

                </div>
            </div>

            <input type="submit" value="Reservar" id="reserva" class="submitPrincipal">

        </form>


    </div>

    <script>
        // Inicializa el tiempo en segundos (5 minutos)
        let totalSeconds = 5 * 60;

        // Función para actualizar el temporizador
        function updateTimer() {
            // Calcula minutos y segundos restantes
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;

            // Formatea los minutos y segundos con dos dígitos
            const formattedMinutes = String(minutes).padStart(2, '0');
            const formattedSeconds = String(seconds).padStart(2, '0');

            // Actualiza el contenido del div
            document.getElementById('timer').textContent = `${formattedMinutes}:${formattedSeconds}`;

            // Decrementa el tiempo
            totalSeconds--;

            // Verifica si el tiempo ha terminado
            if (totalSeconds < 0) {
                clearInterval(timerInterval);
                document.getElementById('timer').textContent = "¡Tiempo terminado!";

                // Deshabilitar el botón de reserva para evitar envío
                const reservaButton = document.getElementById('reserva');
                reservaButton.disabled = true;

                // Mostrar mensaje de tiempo agotado
                alert("El tiempo ha expirado. Ya no puedes realizar la reserva.");
            }
        }

        // Llama a la función cada segundo
        const timerInterval = setInterval(updateTimer, 1000);

        document.addEventListener("DOMContentLoaded", function() {
            // Añadir el EventListener al botón de reserva
            const reservaButton = document.getElementById('reserva');
            reservaButton.addEventListener('click', function(event) {
                event.preventDefault(); // Prevenir el envío por defecto

                // Verificar si el tiempo ha terminado antes de enviar el formulario
                if (typeof totalSeconds !== 'undefined' && totalSeconds < 0) {
                    alert("Tiempo agotado. No puedes realizar la reserva.");
                    return; // Evita que el código continúe si el tiempo está agotado
                }

                // Obtener los valores de los inputs de adultos, infantes y menores
                const adultos = parseInt(document.getElementById('adultos').value) || 0;
                const infantes = parseInt(document.getElementById('infantes').value) || 0;
                const menores = parseInt(document.getElementById('menores').value) || 0;
                const name = document.getElementById('name').value.trim(); // Remover espacios
                const fechaReservacion = document.getElementById('fechaReservacion').value.trim();

                // Verificar si los campos requeridos están llenos
                if (!name || !fechaReservacion) {
                    alert("Por favor, completa todos los campos requeridos.");
                    return;
                }

                // Sumar los valores
                const sumaPersonas = adultos + infantes + menores;

                // Obtener el valor de los asientos
                const asientos = parseInt(document.getElementById('asientos').value);

                // Comprobar si la suma es igual al número de asientos
                if (sumaPersonas === asientos) {
                    // Si coinciden, proceder con la acción (enviar formulario o lo que desees)
                    alert("La cantidad de personas coincide con los asientos disponibles.");

                    // Crear un objeto con los datos a enviar
                    const reservaData = {
                        name: name,
                        fechaReservacion: fechaReservacion,
                        adultos: adultos,
                        infantes: infantes,
                        menores: menores,
                        asientos: asientos
                    };

                    // Enviar los datos al endpoint con fetch
                    fetch('/api/reservar', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(reservaData) // Convierte los datos a formato JSON
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la respuesta del servidor');
                            }
                            return response.json(); // Si la respuesta es JSON, la parsea
                        })
                        .then(data => {
                            if (data.success) {
                                alert("Reserva realizada con éxito.");
                            } else {
                                alert(data.message || "Hubo un error al realizar la reserva.");
                            }
                        })
                        .catch(error => {
                            console.error('Error al enviar la reserva:', error);
                            alert("Hubo un error al enviar los datos. Inténtalo más tarde.");
                        });
                } else {
                    // Si no coinciden, mostrar un mensaje de error
                    alert("La suma de Adultos, Infantes y Menores debe ser igual al número de asientos.");
                }
            });
        });
    </script>


    <script>
        render()
        document.getElementById("fechaReservacion").value = new Date().toISOString().split('T')[0];

        function render() {
            // Número de sillas a generar (puedes cambiar este valor)
            let cantidad_s = document.getElementById("sillasNumber").value
            console.log(cantidad_s);
            const numberOfSilladetails = cantidad_s; // Cambia este número según sea necesario

            // Obtiene el contenedor de detalles
            const detailsMesa = document.querySelector('.detailsMesa');

            // Calcula el radio del círculo alrededor del mainMesa
            const mainMesaSize = 300; // Tamaño de mainMesa (diámetro)
            const radius = (mainMesaSize / 2) + 70; // Radio para silladetail (puedes ajustar la distancia)

            // Centro de mainMesa
            const centerX = detailsMesa.offsetWidth / 2; // Centro del contenedor
            const centerY = detailsMesa.offsetHeight / 2; // Centro del contenedor

            // Obtiene el campo de entrada numérico de asientos
            const asientosInput = document.getElementById('asientosSeleccionados');

            // Inicializa el contador de asientos seleccionados
            let asientosContador = 0;

            for (let i = 0; i < numberOfSilladetails; i++) {
                // Crea un nuevo div para silladetail
                const silladetail = document.createElement('div');
                silladetail.className = 'silladetail';
                silladetail.textContent = i + 1; // Añade el número progresivo

                // Asigna un ID único al silladetail
                silladetail.id = `silladetail-${i + 1}`; // Por ejemplo: silladetail-1, silladetail-2, etc.

                // Calcula la posición de cada silladetail
                const angle = (i / numberOfSilladetails) * (2 * Math.PI); // Convierte a radianes
                const x = radius * Math.cos(angle) + centerX -
                    15; // Ajusta para centrar (15 es la mitad del ancho de silladetail)
                const y = radius * Math.sin(angle) + centerY - 15; // Ajusta para centrar

                // Establece las posiciones calculadas
                silladetail.style.left = `${x}px`;
                silladetail.style.top = `${y}px`;

                // Añade el silladetail al contenedor
                detailsMesa.appendChild(silladetail);

                // Añade el evento click al silladetail
                silladetail.addEventListener('click', function() {
                    const silladetailNumber = silladetail.id.split('-')[
                        1]; // Obtiene el número después de "silladetail-"

                    // Añadir o quitar la clase selected
                    if (silladetail.classList.contains('selected')) {
                        silladetail.classList.remove('selected'); // Remueve la clase si ya está presente
                        // Elimina el número del input
                        asientosInput.value = asientosInput.value.replace(new RegExp(`-?${silladetailNumber}`, 'g'),
                            '').replace(/^-/, ''); // Elimina el número seleccionado
                        asientosContador--; // Decrementa el contador
                    } else {
                        silladetail.classList.add('selected'); // Añade la clase si no está presente
                        // Verifica si el input ya tiene algún valor
                        if (asientosInput.value) {
                            asientosInput.value += '-'; // Añade un guion si ya hay asientos seleccionados
                        }
                        asientosInput.value += silladetailNumber; // Agrega el número del silladetail
                        asientosContador++; // Incrementa el contador
                    }

                    // Actualiza el valor del campo numérico de asientos
                    document.getElementById('asientos').value = asientosContador;
                });
            }
        }
    </script>

</x-app-layout>
