<!-- resources/views/usuario/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Campos de entrada -->

                    <div class="mb-4">
                        <x-label for="name" :value="__('Nombre')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    </div>

                    <div class="mb-4">
                        <x-label for="dni" :value="__('DNI')" />
                        <x-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="ruc" :value="__('RUC')" />
                        <x-input id="ruc" class="block mt-1 w-full" type="text" name="ruc" :value="old('ruc')" />
                    </div>

                    <div class="mb-4">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="correo" :value="__('Correo Alternativo')" />
                        <x-input id="correo" class="block mt-1 w-full" type="email" name="correo" :value="old('correo')" />
                    </div>

                    <div class="mb-4">
                        <x-label for="celular" :value="__('Celular')" />
                        <x-input id="celular" class="block mt-1 w-full" type="text" name="celular" :value="old('celular')" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="rol" :value="__('Rol')" />
                        <select id="rol" name="rol" class="block mt-1 w-full border border-gray-300 rounded-md p-2">
                            <option value="admin">Admin</option>
                            <option value="empresa">Empresa</option>
                            <option value="postulante">Postulante</option>
                            <option value="supervisor">Supervisor</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-label for="archivo_cv" :value="__('Archivo CV')" />
                        <x-input id="archivo_cv" class="block mt-1 w-full" type="file" name="archivo_cv" />
                    </div>

                    <div class="mb-4">
                        <x-label for="password" :value="__('Contraseña')" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Crear Usuario') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
