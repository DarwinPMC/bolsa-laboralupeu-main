<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-chart-bar text-indigo-600 text-3xl"></i>  <!-- Icono al lado del título -->
                <div>
                    <h2 class="text-4xl font-extrabold text-gray-800 leading-tight">
                        {{ __('Reporte de Postulantes y Empresas') }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ __('Consulta el reporte detallado por rango de fechas, empresa o postulante') }}
                    </p>
                </div>
            </div>
            <form method="POST">
                @csrf
                <!-- Inputs ocultos para pasar los filtros al generar el PDF o Excel -->
                <input type="hidden" name="fecha_inicio" value="{{ $fechaInicio ?? '' }}">
                <input type="hidden" name="fecha_fin" value="{{ $fechaFin ?? '' }}">
                <input type="hidden" name="tipo_reporte" value="{{ $tipoReporte ?? 'postulantes' }}">

                <!-- Botón para descargar PDF -->
                <button type="submit" formaction="{{ route('admin.reporte.pdf') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white font-bold rounded-md shadow-md transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-download mr-2"></i>{{ __('Descargar PDF') }}
                </button>

                <!-- Botón para descargar Excel -->
                <button type="submit" formaction="{{ route('admin.reporte.excel') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-md shadow-md transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-file-excel mr-2"></i>{{ __('Descargar Excel') }}
                </button>
            </form>



        </div>
    </x-slot>

    @role('admin')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="p-8">
                        <h3 class="text-2xl font-extrabold text-gray-800 mb-4">Selecciona un Rango de Fechas, Empresa o Postulante</h3>
                        <p class="text-gray-600 mb-6">Selecciona una fecha de inicio, una fecha de fin y si deseas ver los resultados por empresa o por postulante.</p>

                        <form action="{{ route('admin.reporte') }}" method="GET" class="flex items-center justify-between space-x-6 mb-8">
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $fechaInicio ?? '' }}" class="mt-1 block w-full sm:w-64 px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>

                            <div>
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ $fechaFin ?? '' }}" class="mt-1 block w-full sm:w-64 px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            </div>

                            <div>
                                <label for="tipo_reporte" class="block text-sm font-medium text-gray-700">Tipo de Reporte</label>
                                <select name="tipo_reporte" id="tipo_reporte" class="mt-1 block w-full sm:w-64 px-4 py-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    <option value="postulantes" {{ $tipoReporte == 'postulantes' ? 'selected' : '' }}>Postulantes</option>
                                    <option value="empresas" {{ $tipoReporte == 'empresas' ? 'selected' : '' }}>Empresas</option>
                                </select>
                            </div>

                            <div>
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white font-bold rounded-md shadow-md transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-filter mr-2"></i> {{ __('Filtrar') }}
                                </button>
                            </div>
                        </form>

                        {{-- Mostrar los resultados si hay reportes --}}
                        @if(isset($postulantes) && count($postulantes) > 0 && $tipoReporte == 'postulantes')
                            {{-- Tabla para Postulantes --}}
                            <div class="overflow-x-auto">
                                <h4 class="text-xl font-semibold mb-4 text-indigo-600">Postulantes desde {{ \Carbon\Carbon::parse($fechaInicio)->format('d-m-Y') }} hasta {{ \Carbon\Carbon::parse($fechaFin)->format('d-m-Y') }}</h4>

                                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                                    <thead class="bg-gray-100 border-b-2 border-gray-300">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Correo Electrónico</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha de Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($postulantes as $postulante)
                                            <tr class="hover:bg-gray-100 transition duration-200">
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $postulante->name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $postulante->email }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $postulante->created_at->format('d-m-Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif(isset($empresas) && count($empresas) > 0 && $tipoReporte == 'empresas')
                            {{-- Tabla para Empresas --}}
                            <div class="overflow-x-auto">
                                <h4 class="text-xl font-semibold mb-4 text-indigo-600">Empresas desde {{ \Carbon\Carbon::parse($fechaInicio)->format('d-m-Y') }} hasta {{ \Carbon\Carbon::parse($fechaFin)->format('d-m-Y') }}</h4>

                                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                                    <thead class="bg-gray-100 border-b-2 border-gray-300">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre de Empresa</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">RUC</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Correo Electrónico</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha de Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($empresas as $empresa)
                                            <tr class="hover:bg-gray-100 transition duration-200">
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $empresa->name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $empresa->ruc }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $empresa->email }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $empresa->created_at->format('d-m-Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
                                <p class="text-sm text-yellow-700">
                                    No se encontraron resultados para el rango de fechas o tipo de reporte seleccionado.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-red-50 border-l-4 border-red-400 p-4">
            <p class="text-sm text-red-700">
                No tienes permisos para ver esta sección.
            </p>
        </div>
    @endrole
</x-app-layout>
