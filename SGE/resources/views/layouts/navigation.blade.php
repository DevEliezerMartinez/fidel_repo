<sidebar x-data="{ open: false }" class="">
    <div class="sidebar">

        <div class="header_sidebar full_center">
            <div class="user_abreviation" id="userInitials">
                @if (Auth::check())
                    <!-- Verificamos si hay un usuario autenticado -->
                    {{ strtoupper(Auth::user()->username) }} <!-- Mostramos el username en mayúsculas -->
                @else
                    <span>?</span> <!-- Si no hay usuario autenticado, mostramos un signo de interrogación -->
                @endif
            </div>

            <h2>Reservación de eventos</h2>
            <p class="welcome_user">Bienvenido {{ Auth::user()->name . ' ' . Auth::user()->lastname }}</p>

            <div class="location_space">
                @if (Auth::check())
                    @if (Auth::user()->location)
                        <p>{{ Auth::user()->location->name }}</p>
                    @else
                        <span></span>
                    @endif
                @else
                    <span>...</span>
                @endif
            </div>



        </div>

        <div class="options_sidebar">
            <button id="panorama_button" onclick="window.location.href='{{ route('dashboard') }}';">
                <img src="{{ asset('assets/img/icons/stats.png') }}" alt="icon">
                <a class="no_link" href="#">Panorama General</a>
            </button>

            <button id="ajustes">
                <img src="{{ asset('assets/img/icons/tools.png') }}" alt="icon">
                Ajustes
            </button>

            <div class="options_ajustes">
                <a href="{{ route('adminUsuarios') }}" class="botton_option">
                    Administrador de Usuarios
                </a>
                <a href="{{ route('adminEventos') }}" class="botton_option">
                    Administrador de Eventos
                </a>
            </div>

        </div>

        <!-- div para dar espaciado necesario -->
        <div></div>

        <div class="footer_sidebar">
            <form method="POST" action="{{ route('logout') }}">
                @csrf <!-- Token de CSRF para proteger el formulario -->
                <button id="logout" type="submit" class="full_center">
                    <img src="{{ asset('assets/img/icons/logout.png') }}" alt="logout">
                    Cerrar sesión
                </button>
            </form>

            <div class="end_footer full_center">
                <img src="{{ asset('assets/img/Logos/logo_blanco.png') }}" alt="icon">
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/menu_options.js') }}"></script>
</sidebar>
