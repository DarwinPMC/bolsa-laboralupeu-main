<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Acceso Denegado') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-12 text-center">
        <h1 class="text-6xl font-bold text-red-600">403</h1>
        <h2 class="text-4xl mt-4">Acceso Denegado</h2>
        <p class="text-lg mt-4">No tienes permisos para acceder a esta página.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-6">Volver al Dashboard</a>
    </div>
</x-app-layout>
