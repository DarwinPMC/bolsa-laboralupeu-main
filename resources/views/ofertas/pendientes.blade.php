<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 9.75L12 3l9 6.75M9 21V11.25m6 9.75V11.25M9 21H6.75A2.25 2.25 0 0 1 4.5 18.75V9.75m14.25 0v9a2.25 2.25 0 0 1-2.25 2.25H15" />
            </svg>
            {{ __('Ofertas Pendientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800">{{ __('Ofertas Pendientes') }}</h3>
                    <a href="{{ route('ofertas.index') }}"
                    class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-semibold py-1.5 px-4 rounded-md shadow-sm hover:shadow-md transition duration-200 ease-in-out flex items-center space-x-2">
                     <i class="fas fa-briefcase text-sm"></i>
                     <span>Ver Ofertas Activas</span>
                 </a>

                </div>

                @if($ofertasPendientes->isEmpty())
                    <p class="text-gray-500">No hay ofertas pendientes en este momento.</p>
                @else
                    <div class="hidden sm:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                                <thead class="bg-gradient-to-r from-gray-200 via-gray-300 to-gray-400 text-gray-800">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                            Título
                                        </th>
                                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                            Ubicación
                                        </th>
                                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                            Fecha de Inicio
                                        </th>
                                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                            Estado
                                        </th>
                                        <th class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                            Cambiar Fecha de Creacion
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($ofertasPendientes as $oferta)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-yellow-500 text-white">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                {{ $oferta->titulo }}
                                            </td>
                                            <td class="py-4 px-6 text-sm text-gray-500">
                                                {{ $oferta->ubicacion }}
                                            </td>
                                            <td class="py-4 px-6 text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($oferta->fecha_inicio)->format('d-m-Y') }}
                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium">
                                                <span class="text-yellow-500 font-semibold">Pendiente</span>
                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium">
                                                <form action="{{ route('ofertas.fecha_inicio', $oferta->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="date" name="fecha_inicio" class="border rounded p-2" value="{{ \Carbon\Carbon::parse($oferta->fecha_inicio)->format('Y-m-d') }}">

                                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow-md hover:shadow-lg">
                                                        Cambiar
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="block sm:hidden">
                        @foreach($ofertasPendientes as $oferta)
                            <div class="bg-white shadow-md rounded-lg mb-4 p-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $oferta->titulo }}</h3>
                                <p class="text-gray-500 text-sm mb-2">Ubicación: {{ $oferta->ubicacion }}</p>
                                <p class="text-gray-500 text-sm mb-2">Fecha de Inicio: {{ \Carbon\Carbon::parse($oferta->fecha_inicio)->format('d-m-Y') }}</p>
                                <p class="text-sm font-medium">
                                    Estado: <span class="text-yellow-500 font-semibold">Pendiente</span>
                                </p>

                                <form action="{{ route('ofertas.cambiar-fecha', $oferta->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <label for="fecha_inicio">Fecha de Inicio:</label>
                                    <input type="date" name="fecha_inicio" value="{{ \Carbon\Carbon::parse($oferta->fecha_inicio)->format('Y-m-d') }}" class="border rounded p-2">

                                    <label for="oferta_disponible_hasta">Fecha Disponible Hasta:</label>
                                    <input type="date" name="oferta_disponible_hasta" value="{{ \Carbon\Carbon::parse($oferta->oferta_disponible_hasta)->format('Y-m-d') }}" class="border rounded p-2">

                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow-md hover:shadow-lg">
                                        Guardar Cambios
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $ofertasPendientes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
