<!-- resources/views/auth/login.blade.php -->
<x-guest-layout>
    <div class="main_login">
        <div class="login-container">
            <!-- Icono de Usuario -->
            <img src="https://img.icons8.com/ios-filled/100/000000/user-male-circle.png" alt="User Icon">

            <!-- Formulario de inicio de sesión -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">{{ __('Usuario o correo electrónico') }}</label>
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Ingrese su usuario o correo electrónico" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Password -->
                <div class="form-group password-group mt-4">
                    <label for="password">{{ __('Contraseña') }}</label>
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Ingrese su contraseña" />
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span class="ms-2">{{ __('Recuerdame') }}</span>
                    </label>
                </div>

                <!-- Forgot password link -->
                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                    @endif

                    <!-- Botón de Login -->
                    <button type="submit">
                        {{ __('Iniciar sesión') }}
                    </button>
                </div>
            </form>
        </div>

        <span>{{ __('¿No tienes una cuenta  ?') }}</span>
        <a href="{{ route('register') }}" class="ml-2 text-sm text-blue-600 underline hover:text-blue-800">
            {{ __('Registrate') }}
        </a>
    </div>

    <footer>
        <img src="{{ asset('assets/img/Logos/logo_blanco.png') }}" alt="Logo">
    </footer>

    <script>
        // Función para mostrar u ocultar la contraseña
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.querySelector('.toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }
    </script>
</x-guest-layout>