<x-guest-layout>
    <x-authentication-card>
        <div class="md:w-full flex justify-center mb-6">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/login-image.png') }}" alt="Login Image" class="w-40 h-auto">
            </a>
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <x-label for="name" value="{{ __('Nombres y Apellidos completos (o Razón Social)') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>
            <div class="mt-4">
                <x-label for="rol" value="{{ __('Rol') }}" />
                <select id="rol" name="rol" class="block mt-1 w-full" onchange="toggleFieldsBasedOnRole()">
                    <option value="empresa" {{ old('rol') == 'empresa' ? 'selected' : '' }}>Empresa</option>
                    <option value="postulante" {{ old('rol') == 'postulante' ? 'selected' : '' }}>Postulante</option>
                </select>
            </div>
            <div class="mt-4" id="dni-field" style="display: none;">
                <x-label for="dni" value="{{ __('DNI') }}" />
                <x-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')" maxlength="8" pattern="\d{8}" title="El DNI debe tener exactamente 8 dígitos." />
                <p id="dni-error" class="text-red-500 text-sm mt-1" style="display: none;">El DNI debe contener exactamente 8 dígitos numéricos.</p>
            </div>

            <div class="mt-4" id="ruc-field" style="display: none;">
                <x-label for="ruc" value="{{ __('RUC') }}" />
                <x-input id="ruc" class="block mt-1 w-full" type="text" name="ruc" :value="old('ruc')" maxlength="11" pattern="\d{11}" title="El RUC debe tener exactamente 11 dígitos." />
                <p id="ruc-error" class="text-red-500 text-sm mt-1" style="display: none;">El RUC debe contener exactamente 11 dígitos numéricos.</p>
            </div>
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email (Este correo será tu nombre de usuario)') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>
            <div class="mt-4">
                <x-label for="celular" value="{{ __('Celular') }}" />
                <x-input id="celular" class="block mt-1 w-full" type="text" name="celular" :value="old('celular')" />
            </div>
            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>
            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirme Contraseña') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>
            <div class="mt-4" id="cv-upload" style="display: none; transition: opacity 0.3s ease;">
                <x-label for="archivo_cv" value="{{ __('Cargar CV (Opcional)') }}" />

                <div class="mt-2 flex items-center">
                    <label for="archivo_cv" class="cursor-pointer bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Seleccionar archivo') }}
                    </label>
                    <span id="file-name" class="ml-3 text-gray-500">{{ __('Ningún archivo seleccionado') }}</span>
                </div>
                <input id="archivo_cv" class="hidden" type="file" name="archivo_cv" onchange="updateFileName()" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Ya estás registrado?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Registrar') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    <script>
        // Función para alternar los campos en función del rol seleccionado
        function toggleFieldsBasedOnRole() {
            var rol = document.getElementById('rol').value;
            var dniField = document.getElementById('dni-field');
            var rucField = document.getElementById('ruc-field');
            var cvUploadField = document.getElementById('cv-upload');

            // Mostrar/ocultar campos dependiendo del rol seleccionado
            if (rol === 'postulante') {
                dniField.style.display = 'block';
                rucField.style.display = 'none';
                cvUploadField.style.display = 'block';
            } else if (rol === 'empresa') {
                dniField.style.display = 'none';
                rucField.style.display = 'block';
                cvUploadField.style.display = 'none';
            }
        }

        // Función para mostrar el nombre del archivo seleccionado
        function updateFileName() {
            var input = document.getElementById('archivo_cv');
            var fileNameDisplay = document.getElementById('file-name');

            // Verificar si hay archivos seleccionados
            if (input && input.files.length > 0) {
                fileNameDisplay.textContent = input.files[0].name;
            } else {
                fileNameDisplay.textContent = "{{ __('Ningún archivo seleccionado') }}";
            }
        }

        // Ejecutar la función al cargar la página para configurar los campos según el rol
        document.addEventListener('DOMContentLoaded', function() {
            toggleFieldsBasedOnRole();  // Configurar la vista inicial según el rol seleccionado

            // Agregar el evento de cambio al input de archivo solo si existe en el DOM
            var fileInput = document.getElementById('archivo_cv');
            if (fileInput) {
                fileInput.addEventListener('change', updateFileName);
            }
        });
    </script>

    </x-guest-layout>
