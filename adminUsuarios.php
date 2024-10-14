<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Usuarios </title>
    <link rel="stylesheet" href="./assets/css/global.css">
    <link rel="stylesheet" href="./assets/css/sidebar.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/adminUsuarios.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</head>

<body>



    <aside>
        <?php include("./components/sidebar.php") ?>
    </aside>

    <main>
        <div class="main_header">
            <h3>Usuarios</h3>
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

                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal -->
    <div id="userModal" class="modal">
        <div class="modal_content">
            <div class="header_modal">
                <div></div>
                <h2>Registro de Usuario</h2>
                <span class="close">&times;</span>
            </div>
            <form id="addUserForm">
                <label for="nombre">Nombre de anfitrion:</label>
                <input type="text" id="nombre" name="nombre" required>
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>
                <label for="puesto">Puesto:</label>
                <input type="text" id="puesto" name="puesto" required>
                <label for="permisos">Permisos:</label>
                <select name="permisos" id="permisos">
                    <option value="Ninguno">Ninguno</option>
                    <option value="Todos">Todos</option>
                </select>
                <button class="submit_button" type="submit">Agregar Usuario</button>
            </form>
        </div>
    </div>



    <script src="./assets/js/menu_options.js"></script>
    <script src="./assets/js/datepicker.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Función para cargar y renderizar los usuarios
            function loadUsers() {
                // Realiza una solicitud GET a getUsers.php
                fetch('backend/getUsers.php')
                    .then(response => {
                        // Verifica si la respuesta fue exitosa
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Convierte la respuesta a JSON
                    })
                    .then(data => {
                        // Selecciona el cuerpo de la tabla
                        const tableBody = document.querySelector('#tableUser table tbody');
                        // Limpia el cuerpo de la tabla antes de agregar nuevos datos
                        tableBody.innerHTML = '';

                        // Itera sobre los usuarios obtenidos
                        data.usuarios.forEach(user => {
                            // Crea una nueva fila para cada usuario
                            const row = document.createElement('tr');

                            // Crea y agrega las celdas a la fila
                            row.innerHTML = `
                        <td>${user.nombre}</td>
                        <td>${user.correo}</td>
                        <td>${user.puesto}</td>
                        <td>
                            <img src="./assets/img/icons/edit.png" alt="Editar" class="icon" title="Editar" onclick="editUser(${user.id})">
                            <img src="./assets/img/icons/delete.png" alt="Eliminar" class="icon" title="Eliminar" onclick="deleteUser(${user.id})">
                        </td>
                    `;

                            // Agrega la fila al cuerpo de la tabla
                            tableBody.appendChild(row);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching users:', error);
                    });
            }

            // Llama a la función para cargar los usuarios al cargar la página
            loadUsers();
        });

        // Función para editar un usuario
        function editUser(userId) {
            // Aquí puedes agregar el código para manejar la edición del usuario
            console.log('Edit user with ID:', userId);
        }

        // Función para eliminar un usuario
        function deleteUser(userId) {
            // Aquí puedes agregar el código para manejar la eliminación del usuario
            console.log('Delete user with ID:', userId);
        }

        // Obtener el modal
        const modal = document.getElementById('userModal');

        // Obtener el botón que abre el modal
        const addUserButton = document.querySelector('.addUser');

        // Obtener el elemento <span> que cierra el modal
        const spanClose = document.getElementsByClassName('close')[0];

        // Cuando el usuario hace clic en el botón, abrir el modal 
        addUserButton.addEventListener('click', function() {
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

        // Prevent form submission for demonstration purposes (you can handle it later)
        document.getElementById('addUserForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que el formulario se envíe de forma predeterminada
            // Aquí puedes manejar la lógica para agregar un usuario
            console.log('Usuario agregado:', {
                nombre: document.getElementById('nombre').value,
                correo: document.getElementById('correo').value,
                puesto: document.getElementById('puesto').value,
            });
            modal.style.display = 'none'; // Cierra el modal después de agregar el usuario
        });
    </script>

</body>

</html>