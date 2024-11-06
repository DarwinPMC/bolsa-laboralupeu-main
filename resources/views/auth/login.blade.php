<x-guest-layout>
    <x-authentication-card>
        <div class="md:flex md:justify-center md:items-center md:w-3/4 mx-auto">
            <!-- Imagen del logo a la izquierda -->
            <div class="md:w-1/2 flex justify-center md:justify-end mb-6 md:mb-0">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/login-image.png') }}" alt="Login Image" class="w-80 h-auto"> <!-- Aumentar el tamaño a w-80 -->
                </a>
            </div>

            <!-- Formulario a la derecha -->

            <div class="md:w-1/2">

                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Correo') }}" />
                        <x-input id="email" class="block mt-1 w-full text-lg py-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" /> <!-- Aumentar el tamaño del input -->
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Contraseña') }}" />
                        <x-input id="password" class="block mt-1 w-full text-lg py-3" type="password" name="password" required autocomplete="current-password" /> <!-- Aumentar el tamaño del input -->
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-6"> <!-- Aumentar el margen superior -->
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Olvidaste tu contraseña?') }}
                            </a>
                        @endif

                        <x-button class="ms-4 px-8 py-3 text-lg"> <!-- Aumentar el tamaño del botón -->
                            {{ __('Acceder') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
