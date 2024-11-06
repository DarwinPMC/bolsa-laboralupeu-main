<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-4xl font-extrabold text-gray-800 leading-tight">
                    {{ __('Mis Postulaciones') }}
                </h2>
                <p class="text-sm text-gray-500">
                    {{ __('Consulta las ofertas a las que te has postulado por rango de fechas') }}
                </p>
            </div>

            {{-- Botones para descargar PDF o Excel --}}
            <div class="flex space-x-4">
                <form method="POST" class="inline-flex">
                    @csrf
                    <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                    <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">

                    <button type="submit" formaction="{{ route('postulante.reporte.pdf') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white font-bold rounded-md shadow-md">
                        <i class="fas fa-download mr-2"></i>{{ __('PDF') }}
                    </button>
                </form>

                <form method="POST" class="inline-flex">
                    @csrf
                    <input type="hidden" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                    <input type="hidden" name="fecha_fin" value="{{ request('fecha_fin') }}">

                    {{--<button type="submit" formaction="{{ route('postulante.reporte.excel') }}" class="inline-flex items-center px-4 py-2 bg-green-500 text-white font-bold rounded-md shadow-md">
                        <i class="fas fa-file-excel mr-2"></i>{{ __('Excel') }}
                    </button>--}}
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-8">
                    {{-- Filtrar Postulaciones --}}
                    <h3 class="text-2xl font-extrabold text-gray-800 mb-4">Filtrar Postulaciones</h3>

                    <form method="GET" action="{{ route('postulante.reporte') }}">
                        <div class="flex items-center space-x-4 mb-8">
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}" class="mt-1 block w-full sm:w-64 px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>

                            <div>
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}" class="mt-1 block w-full sm:w-64 px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="inline-flex items-center px-5 py-2 bg-indigo-500 text-white font-bold rounded-md shadow-md">
                                    <i class="fas fa-filter mr-2"></i>{{ __('Filtrar') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Mostrar los resultados --}}
                    @if(isset($postulaciones) && count($postulaciones) > 0)
                        <h4 class="text-xl font-semibold mb-4 text-indigo-600">Postulaciones desde {{ $fechaInicio }} hasta {{ $fechaFin }}</h4>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                                <thead class="bg-gray-100 border-b">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">#</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Oferta</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Empresa</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Salario</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Ubicación</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Fecha de Postulación</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($postulaciones as $postulacion)
                                        <tr>
                                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4">{{ $postulacion->oferta->titulo }}</td>
                                            <td class="px-6 py-4">{{ $postulacion->oferta->empresa }}</td>
                                            <td class="px-6 py-4">{{ $postulacion->oferta->salario }}</td>
                                            <td class="px-6 py-4">{{ $postulacion->oferta->ubicacion }}</td>
                                            <td class="px-6 py-4">{{ $postulacion->created_at->format('d-m-Y') }}</td>
                                            <td class="px-6 py-4">
                                                @if($postulacion->estado == 'aceptado')
                                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                        Aceptado
                                                    </span>
                                                @elseif($postulacion->estado == 'rechazado')
                                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                        Rechazado
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                        En espera
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
                            <p class="text-sm text-yellow-700">
                                No se encontraron postulaciones para el rango de fechas seleccionado.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
