<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <!-- Icono de mano estrechando (confianza y bienvenida) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.707 9.293a1 1 0 00-1.414 0L9 14.586l-3.293-3.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l6-6a1 1 0 000-1.414z" />
            </svg>
            <h2 class="text-3xl font-bold text-gray-800 leading-tight">
                {{ __('Bienvenido') }}
            </h2>
        </div>
    </x-slot>





    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
