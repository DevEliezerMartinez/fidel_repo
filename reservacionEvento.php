<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservacion evento </title>
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/sidebar.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/eventos_Master.css">
    <link rel="stylesheet" href="./assets/css/reservacionEvento.css">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</head>

<body>



    <aside>
        <?php include("./components/sidebar.php") ?>
    </aside>

    <main>
        <div class="main_header">
            <h3>Eventos</h3>
            <img id="config" src="./assets/img/icons/config.png" alt="config">
        </div>

        <div class="ticket">
            <div class="card_ticket">
                <div class="card_header">
                    <img src="./assets/img/Logos/logo_color.png" alt="">
                    <div class="number_ticket">#241</div>
                </div>


                <div class="card_body">
                    <h3>Fiesta Mexicana</h3>
                    <div class="row">
                        <p>Descripcion:</p>
                        <span>Fiesta para celebrar el grito de la independencia con increibe mariachi.</span>
                    </div>


                    <div class="row">
                        <p>Fecha evento:</p>
                        <span>2024-12-12</span>
                    </div>


                    <div class="row">
                        <p>Propiedad:</p>
                        <span>Palacio Mundo imperial</span>
                    </div>



                    <div class="row">
                        <p>Lugar:</p>
                        <span>Salon A.</span>
                    </div>



                    <h3>Detalles de la reservacion</h3>

                    <div class="row">
                        <p>Nombre reservacion:</p>
                        <span>Karla Edith Gallardo Santos</span>
                    </div>



                    <div class="row">
                        <p>Fecha reservacion</p>
                        <span>13-09-2024</span>
                    </div>


                </div>





            </div>
        </div>

        <div class="no_info">
            <img src="./assets/img/icons/alert.png" alt="alert">
            <p>Información no disponible</p>
            <span>El evento no tiene información para su reservación</span>
            <a href="./panorama_gral.php">Regresar</a>
        </div>

        <form class="basic_info">
            <div class="sideform">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion"></textarea>
            </div>

            <div class="right_form">
                <div class="options_conteiner">
                    <label for="fecha">Fecha</label>
                    <div class="options date_start">
                        <img src="./assets/img/icons/calendar.png" alt="calendar">
                        <input type="text" id="date_start" placeholder="Fecha de inicio">
                    </div>
                    <div class="options date_end">
                        <img src="./assets/img/icons/calendar.png" alt="calendar">
                        <input type="text" id="date_end" placeholder="Fecha de fin">
                    </div>
                </div>

                <div class="lugar">
                    <label for="Lugar">Lugar:</label>
                    <select name="Lugar" id="Lugar">
                        <option value="Place1">place1</option>
                        <option value="Place2">place2</option>
                        <option value="Place3">place3</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="infomesas">
            <p>Asientos vendidos</p>
            <span class="info_mesa vendidas">0</span>
            <p>Asientos disponibles</p>
            <span class="info_mesa disponibles">10</span>

            <div class="tiempo">
                <p>Tiempo</p>
                <div class="time" id="timer">
                    <img src="./assets/img/icons/Clock.png" alt="clock"> 05:00
                </div>
            </div>
        </div>

        <div class="details">
            <div class="detailsMesa">
                <div class="mainMesa">4</div>
            </div>

            <form class="info_details">
                <h4>Detalles de la reservacion</h4>

                <div class="detailsReservacion">
                    <p>No. de mesa</p>
                    <input type="number" name="mesaNumber" id="mesaNumber">
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
                    <input type="number" name="asientos" id="asientos">
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
    </main>


    <script src="./assets/js/menu_options.js"></script>

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
            }
        }

        // Llama a la función cada segundo
        const timerInterval = setInterval(updateTimer, 1000);
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Verificar si visualizerConfig existe en localStorage
            const visualizerConfig = localStorage.getItem("visualizerConfig");

            // Obtener elementos de la interfaz
            const noInfoSection = document.querySelector('.no_info');
            const infoSection = document.querySelector('.detailsMesa');

            if (visualizerConfig) {
                // Si visualizerConfig existe, muestra la sección .info y oculta .no_info
                noInfoSection.style.display = 'none';
                infoSection.style.display = 'block';
                render();

                // Cargar y renderizar la configuración almacenada
                const configData = JSON.parse(visualizerConfig);
            } else {
                // Si visualizerConfig no existe, muestra la sección .no_info y oculta .info
                noInfoSection.style.display = 'block';
                infoSection.style.display = 'none';
            }
        });

        function render() {
            // Número de silladetail a generar (puedes cambiar este valor)
            const numberOfSilladetails = 10; // Cambia este número según sea necesario

            // Obtiene el contenedor de detalles
            const detailsMesa = document.querySelector('.detailsMesa');

            // Calcula el radio del círculo alrededor del mainMesa
            const mainMesaSize = 300; // Tamaño de mainMesa (diámetro)
            const radius = (mainMesaSize / 2) + 70; // Radio para silladetail (puedes ajustar la distancia)

            // Centro de mainMesa
            const centerX = detailsMesa.offsetWidth / 2; // Centro del contenedor
            const centerY = detailsMesa.offsetHeight / 2; // Centro del contenedor

            for (let i = 0; i < numberOfSilladetails; i++) {
                // Crea un nuevo div para silladetail
                const silladetail = document.createElement('div');
                silladetail.className = 'silladetail';
                silladetail.textContent = i + 1; // Añade el número progresivo

                // Asigna un ID único al silladetail
                silladetail.id = `silladetail-${i + 1}`; // Por ejemplo: silladetail-1, silladetail-2, etc.

                // Calcula la posición de cada silladetail
                const angle = (i / numberOfSilladetails) * (2 * Math.PI); // Convierte a radianes
                const x = radius * Math.cos(angle) + centerX - 15; // Ajusta para centrar (15 es la mitad del ancho de silladetail)
                const y = radius * Math.sin(angle) + centerY - 15; // Ajusta para centrar

                // Establece las posiciones calculadas
                silladetail.style.left = `${x}px`;
                silladetail.style.top = `${y}px`;

                // Añade el silladetail al contenedor
                detailsMesa.appendChild(silladetail);

                // Añade el evento click al silladetail
                silladetail.addEventListener('click', function() {
                    const asientosInput = document.getElementById('asientosSeleccionados');

                    // Extraer el número del ID (ej. silladetail-1 -> 1)
                    const silladetailNumber = silladetail.id.split('-')[1]; // Obtiene el número después de "silladetail-"

                    // Añadir o quitar la clase selected
                    if (silladetail.classList.contains('selected')) {
                        silladetail.classList.remove('selected'); // Remueve la clase si ya está presente
                        // Elimina el número del input
                        asientosInput.value = asientosInput.value.replace(new RegExp(`-?${silladetailNumber}`, 'g'), '').replace(/^-/, ''); // Elimina el número seleccionado
                    } else {
                        silladetail.classList.add('selected'); // Añade la clase si no está presente

                        // Verifica si el input ya tiene algún valor
                        if (asientosInput.value) {
                            asientosInput.value += '-'; // Añade un guion si ya hay asientos seleccionados
                        }

                        asientosInput.value += silladetailNumber; // Agrega el número del silladetail
                    }
                });
            }
        }


        document.addEventListener("DOMContentLoaded", function() {
            // Añadir el EventListener al botón de reserva
            const reservaButton = document.getElementById('reserva');
            reservaButton.addEventListener('click', function(event) {
                event.preventDefault(); // Previene la acción predeterminada (enviar formulario)

                // Selecciona y elimina los elementos deseados
                const noInfo = document.querySelector('.no_info');
                const basicInfo = document.querySelector('.basic_info');
                const infoMesas = document.querySelector('.infomesas');
                const details = document.querySelector('.details');

                if (noInfo) noInfo.remove(); // Elimina el div con clase no_info
                if (basicInfo) basicInfo.remove(); // Elimina el formulario con clase basic_info
                if (infoMesas) infoMesas.remove(); // Elimina el div con clase infomesas
                if (details) details.remove(); // Elimina el div con clase details

                const ticker = document.querySelector('.ticket');
                if (ticker) ticker.style.display = 'block';
            });
        });
    </script>


</body>

</html>