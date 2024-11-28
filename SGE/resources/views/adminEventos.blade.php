<x-app-layout>

    <div class="main_header">
        <h3>Admin eventos</h3>
        <img id="config" src="{{ asset('assets/img/icons/config.png') }}" alt="config">


        <div class="options_config">
            @foreach ($locations as $location)
                <span id="ubicacion-{{ Str::slug($location->name) }}" data-ubicacion="{{ $location->name }}"
                    class="botton_option {{ $ubicacion == $location->name ? 'active' : '' }}"
                    onclick="setUbicacion('{{ $location->name }}')">
                    {{ $location->name }}
                </span>
            @endforeach

            <span id="ubicacion-todos" data-ubicacion="Todos"
                class="botton_option {{ $ubicacion == 'Todos' ? 'active' : '' }}" onclick="setUbicacion('Todos')">
                Todos
            </span>

            <form method="GET" id="filterForm">
                <input type="hidden" name="ubicacion" id="ubicacion" value="{{ $ubicacion }}">
            </form>
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
                    @forelse ($events as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->event_date)->locale('es')->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ $event->space->location->name ?? 'Sin ubicación' }}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" id="eventSwitch_{{ $event->id }}"
                                        onchange="toggleEventStatus({{ $event->id }}, this.checked)"
                                        {{ $event->status == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                                <img src="{{ asset('assets/img/icons/edit.png') }}" alt="Editar" class="icon"
                                    title="Editar" onclick="editEvent({{ $event->id }})">
                                <img src="{{ asset('assets/img/icons/delete.png') }}" alt="Eliminar" class="icon"
                                    title="Eliminar" onclick="deleteEvent({{ $event->id }})">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No hay eventos disponibles para esta ubicación.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </section>

    <!-- Modal -->
    <div id="eventModal" class="modal" style="display: none;">
        <div class="modal_content">
            <div class="header_modal">
                <div></div>
                <h2 id="modalTitle">Registro de Evento</h2> <!-- Cambia el título dinámicamente -->
                <span class="close">&times;</span>
            </div>
            <form id="eventForm">
                <input type="hidden" id="eventId" name="eventId"> <!-- ID para identificar el evento en edición -->
                <label for="nombre">Nombre del evento:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
                <label for="capacidad">Capacidad:</label>
                <input type="number" id="capacidad" name="capacidad" required>
               <!--  <label for="color">Color:</label>
                <input type="color" id="color" name="color" required> -->
                <label for="lugar">Lugar:</label>
                <select id="lugar" name="lugar" required>
                    <option value="">Selecciona una ubicación</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
                <button class="submit_button" id="submitButton" type="submit">Agregar Evento</button>
            </form>
        </div>
    </div>


    <script>
        function setUbicacion(ubicacion) {
            document.getElementById('ubicacion').value = ubicacion;
            document.getElementById('filterForm').submit();
        }

        function deleteEvent(eventId) {
            if (confirm("¿Estás seguro de que deseas eliminar este evento? Esta acción no se puede deshacer.")) {
                fetch(`/events/${eventId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.success);
                            location.reload();
                        } else {
                            alert(data.error || "Error al eliminar el evento");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Ocurrió un error al eliminar el evento");
                    });
            }
        }

        const modal = document.getElementById('eventModal');
        const addEventButton = document.querySelector('.addEvent');
        const spanClose = document.querySelector('.close');

        let editEventId = null;

        // Mostrar el modal al hacer clic en el botón de agregar
        addEventButton.addEventListener('click', function() {
            editEventId = null; // No se está editando ningún evento
            document.getElementById('eventForm').reset(); // Limpiar el formulario
            document.getElementById('modalTitle').textContent = "Registro de Evento"; // Cambiar título del modal
            document.getElementById('submitButton').textContent = "Agregar Evento"; // Cambiar texto del botón
            modal.style.display = 'block';
        });

        // Redirigir a la vista eventos_master al hacer clic en editar
        function editEvent(eventId) {
            const url = `/eventos_master/${eventId}`; // Ajusta la ruta según tu configuración
            window.location.href = url; // Redirigir a la nueva vista con el ID del evento
        }



        // Cerrar el modal al hacer clic en la "X"
        spanClose.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Cerrar el modal al hacer clic fuera de él
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Manejo del formulario de agregar/editar evento
        document.getElementById('eventForm').addEventListener('submit', function(event) {

            event.preventDefault();

            const nombre = document.getElementById('nombre').value;
            const fecha = document.getElementById('fecha').value;
            const lugar = document.getElementById('lugar').value;
            const capacidad = document.getElementById('capacidad').value;
            /* const color_s = document.getElementById('color').value; */

            const eventData = {
                nombre,
                fecha,
                lugar,
                capacidad,
               /*  color_s */
            };
            const url = editEventId ? `/events/${editEventId}` : "{{ route('events.store') }}";
            const method = editEventId ? "PUT" : "POST";

            fetch(url, {
                    method: method,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(eventData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        location.reload();
                    } else {
                        let errorMessage = data.error || "Error al guardar el evento";
                        if (data.details) {
                            errorMessage += "\nDetalles:\n" + JSON.stringify(data.details, null, 2);
                        }
                        alert(errorMessage);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Ocurrió un error al guardar el evento. Detalles en consola.");
                });

            modal.style.display = 'none';
        });


        function toggleEventStatus(eventId, status) {
            const isActive = status ? true : false; // Convertir a true o false explícitamente

            fetch(`/events/${eventId}/toggle-status`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        status: isActive
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data.success);
                    } else {
                        alert(data.error || "Error al actualizar el estado del evento.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Ocurrió un error al cambiar el estado del evento.");
                });
        }
    </script>



    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
</x-app-layout>
