<sidebar x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="sidebar">

        <div class="header_sidebar full_center">
            <div class="user_abreviation" id="userInitials">
                @if(Auth::check()) <!-- Verificamos si hay un usuario autenticado -->
                {{ strtoupper(Auth::user()->username) }} <!-- Mostramos el username en mayúsculas -->
                @else
                <span>?</span> <!-- Si no hay usuario autenticado, mostramos un signo de interrogación -->
                @endif

            </div>

            <h2>Reservación de eventos</h2>
            <p>Bienvenido <span id="userName">{{ Auth::user()->name . ' ' . Auth::user()->lastname }}</span></p>
            <span> </span>
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
            <form method="POST" action="{{ route('logout') }}">
                @csrf <!-- Token de CSRF para proteger el formulario -->
                <button type="submit" class="full_center">
                    <img src="assets/img/icons/logout.png" alt="logout">
                    Cerrar sesión
                </button>
            </form>

            <div class="end_footer full_center">
                <img src="assets/img/Logos/logo_blanco.png" alt="icon">
            </div>
        </div>
    </div>



    <script src="./assets/js/menu_options.js"></script>
</nav>