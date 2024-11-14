<x-app-layout>

    <p>admin usuario</p>

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

                        <td>
                            <a href="#" onclick="editUser({{ $user->id }})">
                                <img src="./assets/img/icons/edit.png" alt="Editar" class="icon" title="Editar">
                            </a>
                            <img src="./assets/img/icons/delete.png" alt="Eliminar" class="icon" title="Eliminar" onclick="deleteUser({{ $user->id }})">
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
            <form id="userForm" action="{{ route('usuarios.store') }}" method="POST">
                @csrf <!-- Para proteger contra CSRF -->
                <label for="nombre">Nombre de anfitrión:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>

                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>

                <label for="puesto">Puesto:</label>
                <input type="text" id="puesto" name="puesto">

                <label for="permisos">Permisos:</label>
                <select name="permisos" id="permisos">
                    <option value="Ninguno">Ninguno</option>
                    <option value="3">Admin</option>
                    <option value="2">Master</option>
                    <option value="1">Usuario</option>
                </select>

                <button class="submit_button" type="submit" id="submitButton">Agregar Usuario</button>
            </form>
        </div>
    </div>

    <script>
        // Función para editar un usuario
        function editUser(userId) {
            // Hacer una solicitud GET para obtener los datos del usuario
            fetch(`/usuarios/${userId}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Prellenar el formulario del modal con los datos del usuario
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('apellido').value = data.apellido;
                    document.getElementById('correo').value = data.correo;
                    document.getElementById('puesto').value = data.puesto;
                    document.getElementById('permisos').value = data.permisos;

                    // Cambiar el título del modal y la acción del formulario para que apunte a la ruta de actualización
                    document.getElementById('modalTitle').innerText = "Editar Usuario";
                    document.getElementById('userForm').action = `/usuarios/${userId}`;
                    document.getElementById('submitButton').innerText = "Actualizar Usuario";

                    // Mostrar el modal
                    document.getElementById('userModal').style.display = "block";
                })
                .catch(error => {
                    console.error('Error:', error);
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
        addUserButton.addEventListener('click', function() {
            // Limpiar el formulario antes de abrir
            document.getElementById('userForm').reset();
            document.getElementById('modalTitle').innerText = "Registro de Usuario";
            document.getElementById('submitButton').innerText = "Agregar Usuario";
            document.getElementById('userForm').action = "{{ route('usuarios.store') }}";
            modal.style.display = 'block';
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
