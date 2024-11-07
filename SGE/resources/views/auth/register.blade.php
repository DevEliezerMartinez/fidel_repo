<x-guest-layout>

    <div class="main_login">
        <div class="login-container">
            <h2>{{ __('Registro') }}</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre -->
                <div class="form-group">
                    <label for="name">{{ __('Nombre') }}</label>
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="Ingrese su nombre" />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div class="form-group mt-4">
                    <label for="email">{{ __('Correo Electrónico') }}</label>
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required placeholder="Ingrese su correo electrónico" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Contraseña -->
                <div class="form-group mt-4">
                    <label for="password">{{ __('Contraseña') }}</label>
                    <x-text-input id="password" type="password" name="password" required placeholder="Ingrese su contraseña" />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <!-- Confirmar Contraseña -->
                <div class="form-group mt-4">
                    <label for="password_confirmation">{{ __('Confirmar Contraseña') }}</label>
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirme su contraseña" />
                    <x-input-error :messages="$errors->get('password_confirmation')" />
                </div>

                <!-- Botón de Registro -->
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 underline hover:text-blue-800">
                        {{ __('¿Ya tienes una cuenta? Inicia sesión') }}
                    </a>

                    <button type="submit" class="ml-4">
                        {{ __('Registrarse') }}
                    </button>
                </div>
            </form>
        </div>
       
    </div>
    <footer>
            <img src="{{ asset('assets/img/Logos/logo_blanco.png') }}" alt="Logo">
        </footer>
</x-guest-layout>