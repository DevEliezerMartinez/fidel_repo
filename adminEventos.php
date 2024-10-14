<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Eventos</title>
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/sidebar.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/adminEventos.css">

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

            <div class="options_config">
                <span data-ubicacion="Palacio mundo imperial" class="botton_option">
                    Palacio mundo imperial
                </span>
                <span data-ubicacion="Princess mundo imperial" class="botton_option">
                    Princess mundo imperial
                </span>
                <span data-ubicacion="Todos" class="botton_option">
                    Todos
                </span>

                <input type="hidden" name="ubicacion" id="ubicacion" value="Todos">
            </div>
        </div>

        <div class="options_conteiner">
            <button class="addEvent">Generar evento</button>
        </div>

        <section id="tableEvent">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Lugar</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los eventos se cargarán aquí -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal -->
    <div id="eventModal" class="modal">
        <div class="modal_content">
            <div class="header_modal">
                <div></div>
                <h2>Registro de Evento</h2>
                <span class="close">&times;</span>
            </div>
            <form id="addUserForm">
                <label for="nombre">Nombre del evento:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
                <label for="lugar">Lugar:</label>
                <input type="text" id="lugar" name="lugar" required>
                <button class="submit_button" type="submit">Agregar Evento</button>
            </form>
        </div>
    </div>

    <script src="./assets/js/menu_options.js"></script>
   

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Función para cargar y renderizar los eventos
            function loadEvents() {
                // Realiza una solicitud GET a getEvents.php
                fetch('backend/getEvents.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Convierte la respuesta a JSON
                    })
                    .then(data => {
                        const tableBody = document.querySelector('#tableEvent table tbody');
                        tableBody.innerHTML = '';

                        // Itera sobre los eventos obtenidos
                        data.eventos.forEach(event => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${event.nombre}</td>
                                <td>${event.fecha}</td>
                                <td>${event.ubicacion}</td>
                                <td>
                                <label class="switch">
                                     <input type="checkbox" id="eventSwitch_${event.id}" onchange="toggleEventStatus(${event.id}, this.checked)" ${event.estado === 'activo' ? 'checked' : ''}>
                                        <span class="slider round"></span>
                                 </label>
                                    <img src="./assets/img/icons/edit.png" alt="Editar" class="icon" title="Editar" onclick="editEvent(${event.id})">
                                    <img src="./assets/img/icons/delete.png" alt="Eliminar" class="icon" title="Eliminar" onclick="deleteEvent(${event.id})">
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching events:', error);
                    });
            }

            // Carga los eventos al cargar la página
            loadEvents();
        });

        // Función para editar un evento
        function editEvent(eventId) {
            console.log('Edit event with ID:', eventId);
            window.location.href = './';

        }

        // Función para eliminar un evento
        function deleteEvent(eventId) {
            console.log('Delete event with ID:', eventId);
        }

        // Obtener el modal
        const modal = document.getElementById('eventModal');
        const addEventButton = document.querySelector('.addEvent');
        const spanClose = document.getElementsByClassName('close')[0];

        // Cuando el usuario hace clic en el botón, abrir el modal 
        addEventButton.addEventListener('click', function() {
            modal.style.display = 'block';
        });

        // Cerrar el modal
        spanClose.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Cerrar el modal al hacer clic fuera de él
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Manejo de la lógica para agregar un evento
        document.getElementById('addEventForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que el formulario se envíe de forma predeterminada
            console.log('Evento agregado:', {
                nombre: document.getElementById('nombre').value,
                fecha: document.getElementById('fecha').value,
                lugar: document.getElementById('lugar').value,
            });
            modal.style.display = 'none'; // Cierra el modal después de agregar el evento
        });
    </script>

</body>

</html>