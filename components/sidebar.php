<div class="sidebar">

    <div class="header_sidebar full_center">
        <div class="user_abreviation" id="userInitials">
            <!-- Iniciales se actualizarán aquí -->
        </div>

        <h2>Reservación de eventos</h2>
        <p>Bienvenido <span id="userName"></span></p>
        <span>Mundo imperial</span>
    </div>

    <div class="options_sidebar">
        <button>
            <img src="assets/img/icons/stats.png" alt="icon">
            <a class="no_link" href="./panorama_gral.php"> Panorama General</a>
           
        </button>
        <button id="ajustes">
            <img src="assets/img/icons/tools.png" alt="icon">
            Ajustes
        </button>

        <div class="options_ajustes">
            <a href="./adminUsuarios.php" class="botton_option">
                Administrador de Usuarios
            </a>
            <a href="./adminEventos.php" class="botton_option">
                Administrador de Eventos
            </a>

        </div>
    </div>

    <!-- div para dar espaciado necesario -->
    <div></div> 

    <div class="footer_sidebar">
        <button class="full_center">
            <img src="assets/img/icons/logout.png" alt="logout">
            Cerrar sesión
        </button>
        <div class="end_footer full_center">
            <img src="assets/img/Logos/logo_blanco.png" alt="icon">
        </div>
    </div>
</div>



<script>
    // Función para cargar los datos del usuario desde localStorage
    function loadUserInfo() {
        // Obtener el objeto 'user' del localStorage
        const user = JSON.parse(localStorage.getItem('user'));

        if (user && user.iniciales && user.nombre) {
            document.getElementById('userInitials').textContent = user.iniciales;
            document.getElementById('userName').textContent = user.nombre;
        } else {
            console.error('No se encontraron las propiedades iniciales y nombre en el objeto user.');
        }
    }

    loadUserInfo();
</script>