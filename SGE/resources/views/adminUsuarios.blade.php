<x-app-layout>

    <h3>Usuarios</h3>

    <div class="options_conteiner">
        <button class="addUser">Generar usuario</button>
    </div>

    <section id="tableUser">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Puesto</th>
                        <th>Asignado a: </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Recorrer los usuarios dinámicamente -->
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td> <!-- Aquí usas el campo "correo" que agregaste -->
                            <td>{{ $user->puesto ?: 'Sin asignar' }}</td>
                            <td>{{ $user->location->name ?? 'Sin asignar' }}</td>

                            <td>
                                <a href="#" onclick="editUser({{ $user->id }})">
                                    <img src="./assets/img/icons/edit.png" alt="Editar" class="icon" title="Editar"></a>
                                <img src="./assets/img/icons/delete.png" alt="Eliminar" class="icon" title="Eliminar"
                                    onclick="deleteUser({{ $user->id }})">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Modal -->
    <div id="userModal" class="modal">
        <div class="modal_content">
            <div class="header_modal">
                <div></div>
                <h2 id="modalTitle">Registro de Usuario</h2>
                <span class="close">&times;</span>
            </div>
            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>

                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>

                <label for="puesto">Puesto:</label>
                <input type="text" id="puesto" name="puesto">

                <label for="asignado">Asignado a:</label>
                <select id="asignado" name="asignado">
                    <!-- Opciones serán cargadas dinámicamente con JavaScript -->
                </select>


                <label for="permisos">Permisos:</label>
                <select name="permisos" id="permisos">
                    <option value="Ninguno">Ninguno</option>
                    <option value="3">Admin</option>
                    <option value="2">Master</option>
                    <option value="1">Usuario</option>
                </select>

                <button class="submit_button" type="submit" id="submitButton">Registrar Usuario</button>
            </form>
        </div>
    </div>


    <script>
        // Función para editar un usuario
        function editUser(userId) {
            fetch(`/usuarios/${userId}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Prellenar el formulario
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('apellido').value = data.apellido;
                    document.getElementById('correo').value = data.correo;
                    document.getElementById('puesto').value = data.puesto;
                    document.getElementById('permisos').value = data.permisos;

                    // Rellenar el select de asignado
                    const asignadoSelect = document.getElementById('asignado');
                    asignadoSelect.innerHTML = ''; // Limpiar opciones previas

                    // Crear la opción "Seleccione" si no se encuentra ninguna coincidencia
                    const selectOption = document.createElement('option');
                    selectOption.value = ''; // Valor vacío para indicar que es la opción predeterminada
                    selectOption.textContent = 'Seleccione'; // Texto de la opción predeterminada
                    selectOption.selected = true; // Marcar como seleccionada por defecto
                    asignadoSelect.appendChild(selectOption);

                    let selected = false; // Variable para verificar si se seleccionó alguna opción

                    data.locations.forEach(location => {
                        const option = document.createElement('option');
                        option.value = location.id;
                        option.textContent = location.name;

                        // Si el ID coincide con el de la base de datos, se marca como seleccionado
                        if (location.id === data.location_id) {
                            option.selected = true;
                            selected = true; // Marcar como seleccionado
                        }

                        asignadoSelect.appendChild(option);
                    });

                    // Si no se encontró ninguna coincidencia, la opción "Seleccione" ya está seleccionada




                    // Configurar el formulario para editar
                    document.getElementById('formMethod').value = "PUT";
                    document.getElementById('userForm').action = `/usuarios/${userId}`;
                    document.getElementById('modalTitle').innerText = "Editar Usuario";
                    document.getElementById('submitButton').innerText = "Actualizar Usuario";

                    document.getElementById('userModal').style.display = 'block';
                });
        }


        function createUser() {
            fetch('/locations') // O donde estés obteniendo las ubicaciones
                .then(response => response.json())
                .then(data => {
                    console.log("responsee",data)
                    // Rellenar el select de asignado
                    const asignadoSelect = document.getElementById('asignado');
                    asignadoSelect.innerHTML = ''; // Limpiar opciones previas

                    // Crear la opción "Seleccione"
                    const selectOption = document.createElement('option');
                    selectOption.value = ''; // Valor vacío para indicar que es la opción predeterminada
                    selectOption.textContent = 'Seleccione'; // Texto de la opción predeterminada
                    selectOption.selected = true; // Marcar como seleccionada por defecto
                    asignadoSelect.appendChild(selectOption);

                    // Agregar las ubicaciones
                    data.locations.forEach(location => {
                        const option = document.createElement('option');
                        option.value = location.id;
                        option.textContent = location.name;
                        asignadoSelect.appendChild(option);
                    });

                    // Configurar el formulario para crear el usuario
                    document.getElementById('formMethod').value = "POST"; // Método POST para crear
                    document.getElementById('userForm').action = '/usuarios/crear'; // Acción para crear usuario
                    document.getElementById('modalTitle').innerText = "Crear Usuario"; // Título del modal
                    document.getElementById('submitButton').innerText = "Crear Usuario"; // Texto del botón

                    document.getElementById('userModal').style.display = 'block'; // Mostrar el modal
                });
        }


        // Función para eliminar un usuario
        function deleteUser(userId) {
            if (confirm('¿Seguro que deseas eliminar este usuario?')) {
                fetch(`/usuarios/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            alert('Usuario eliminado');
                            location.reload(); // Recargar la página después de eliminar
                        } else {
                            alert('Error al eliminar el usuario');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Obtener el modal
        const modal = document.getElementById('userModal');

        // Obtener el botón que abre el modal
        const addUserButton = document.querySelector('.addUser');

        // Obtener el elemento <span> que cierra el modal
        const spanClose = document.getElementsByClassName('close')[0];

        // Cuando el usuario hace clic en el botón, abrir el modal 
        // Abrir modal para crear usuario
        // Evento para abrir modal al crear usuario
        addUserButton.addEventListener('click', function() {
            document.getElementById('userForm').reset(); // Limpiar el formulario
            document.getElementById('formMethod').value = "POST"; // Configurar método POST
            document.getElementById('userForm').action =
                "{{ route('usuarios.store') }}"; // Configurar la ruta para crear
            document.getElementById('modalTitle').innerText = "Registrar Usuario"; // Título del modal
            document.getElementById('submitButton').innerText = "Registrar Usuario"; // Botón de enviar
            createUser()

            document.getElementById('userModal').style.display = 'block'; // Mostrar el modal
        });


        // Cuando el usuario hace clic en <span> (x), cerrar el modal
        spanClose.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Cuando el usuario hace clic en cualquier parte fuera del modal, cerrarlo
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>



</x-app-layout>
