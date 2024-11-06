<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 leading-tight text-center">
            {{ __('Editar Perfil de Usuario') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-10 lg:p-12">
                <div class="flex justify-center mb-10">
                    <div class="relative group">
                        <div class="rounded-full border-4 border-indigo-600 p-1 bg-white">
                            <img id="profile-photo-preview"
                                class="h-48 w-48 rounded-full object-cover transition-transform duration-300 group-hover:scale-105"
                                src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.png') }}"
                                alt="{{ Auth::user()->name }}">
                        </div>
                        <div
                            class="absolute inset-0 bg-black bg-opacity-60 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer">
                            <label for="profile_photo"
                                class="text-white text-base font-bold px-4 py-2 bg-indigo-500 rounded-lg shadow hover:bg-indigo-600">
                                Cambiar Foto
                            </label>
                        </div>
                    </div>
                </div>
                <form action="{{ route('usuarios.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-8">
                    @csrf
                    @method('PUT')
                    <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden" />
                    @error('profile_photo')
                        <div class="text-red-500 text-center text-sm mt-1">{{ $message }}</div>
                    @enderror
                    <div class="flex flex-col">
                        <label for="name" class="text-lg font-semibold text-gray-700">Nombre Completo</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="mt-2 px-4 py-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('name') border-red-500 @enderror"
                            placeholder="Escribe tu nombre completo">
                        @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($user->rol == 'postulante')
                        <div class="flex flex-col">
                            <label for="dni" class="text-lg font-semibold text-gray-700">Documento de Identidad
                                (DNI)</label>
                            <input type="text" name="dni" id="dni" value="{{ old('dni', $user->dni) }}"
                                class="mt-2 px-4 py-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('dni') border-red-500 @enderror"
                                placeholder="Escribe tu DNI">
                            @error('dni')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    @if ($user->rol == 'empresa')
                        <div class="flex flex-col">
                            <label for="ruc" class="text-lg font-semibold text-gray-700">Registro Único de
                                Contribuyente (RUC)</label>
                            <input type="text" name="ruc" id="ruc" value="{{ old('ruc', $user->ruc) }}"
                                class="mt-2 px-4 py-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('ruc') border-red-500 @enderror"
                                placeholder="Escribe tu RUC">
                            @error('ruc')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <label for="email" class="text-lg font-semibold text-gray-700">Correo Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="mt-2 px-4 py-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('email') border-red-500 @enderror"
                            placeholder="Escribe tu correo electrónico">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="celular" class="text-lg font-semibold text-gray-700">Celular</label>
                        <input type="text" name="celular" id="celular"
                            value="{{ old('celular', $user->celular) }}"
                            class="mt-2 px-4 py-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('celular') border-red-500 @enderror"
                            placeholder="Escribe tu número de celular">
                        @error('celular')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    @if (Auth::user()->rol == 'admin')
                        <div class="flex flex-col">
                            <label for="rol" class="text-lg font-semibold text-gray-700">Rol de Usuario</label>
                            <select name="rol" id="rol"
                                class="mt-2 px-4 py-3 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 @error('rol') border-red-500 @enderror">
                                <option value="admin" {{ old('rol', $user->rol) == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="empresa" {{ old('rol', $user->rol) == 'empresa' ? 'selected' : '' }}>
                                    Empresa</option>
                                <option value="postulante"
                                    {{ old('rol', $user->rol) == 'postulante' ? 'selected' : '' }}>Postulante</option>
                                <option value="supervisor"
                                    {{ old('rol', $user->rol) == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                            </select>
                            @error('rol')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <input type="hidden" name="rol" value="{{ $user->rol }}">
                    @endif
                    @if (old('rol', $user->rol) == 'postulante')
                        <div class="flex flex-col">
                            <label for="archivo_cv" class="text-lg font-semibold text-gray-700 mb-2">Archivo CV
                                (PDF)</label>
                            <div class="flex flex-col items-center space-y-3">
                                <label for="archivo_cv"
                                    class="cursor-pointer bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:from-indigo-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Subir CV
                                </label>
                                <input type="file" name="archivo_cv" id="archivo_cv" accept=".pdf"
                                    class="hidden">
                                <div id="archivo_cv_info"
                                    class="flex items-center space-x-2 text-sm text-gray-500 mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h10M7 12h10M7 17h6" />
                                    </svg>
                                    <span id="archivo_cv_name">Ningún archivo seleccionado</span>
                                </div>
                            </div>

                            @if ($user->archivo_cv)
                                <div class="mt-6 text-center">
                                    <a href="{{ asset('storage/' . $user->archivo_cv) }}" target="_blank"
                                        class="text-indigo-600 hover:text-indigo-700 font-semibold underline">
                                        Ver CV Actual
                                    </a>
                                </div>
                            @endif

                            @error('archivo_cv')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <script>
                            document.getElementById('archivo_cv').addEventListener('change', function(event) {
                                const fileName = event.target.files[0]?.name;
                                const infoElement = document.getElementById('archivo_cv_info');
                                const nameElement = document.getElementById('archivo_cv_name');

                                if (fileName) {
                                    nameElement.textContent = fileName;
                                    infoElement.classList.remove('hidden'); // Muestra la info del archivo
                                } else {
                                    nameElement.textContent = 'Ningún archivo seleccionado';
                                }
                            });
                        </script>


                    @endif

                    <div class="flex justify-center mt-10 space-x-4">
                        <button type="submit"
                            class="bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-semibold px-6 py-3 rounded-md shadow-md hover:from-indigo-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            Actualizar Perfil
                        </button>

                        <a href="{{ route('dashboard') }}"
                            class="bg-gray-500 text-white font-semibold px-6 py-3 rounded-md shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200">
                            Volver al Dashboard
                        </a>

                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    document.getElementById('profile_photo').addEventListener('change', function(event) {
        const reader = new FileReader();
        const file = event.target.files[0];

        reader.onload = function(e) {
            document.getElementById('profile-photo-preview').src = e.target.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });
</script>
