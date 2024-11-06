@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Buscar Ofertas Laborales') }}
            </h2>
            <p class="text-gray-500 mt-2 text-lg">Explora las mejores oportunidades laborales disponibles para ti.</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('buscar_oferta') }}" method="GET" class="mb-10 bg-white p-6 rounded-lg shadow-md">
                <div class="flex flex-wrap gap-4 items-end">
                    <!-- Campo Empresa -->
                    <div class="flex-grow min-w-0">
                        <label for="empresa" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-building mr-1"></i> Empresa
                        </label>
                        <input type="text" name="empresa" id="empresa" value="{{ request('empresa') }}"
                            class="mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm">
                    </div>

                    <!-- Campo Ubicación -->
                    <div class="flex-grow min-w-0">
                        <label for="ubicacion" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-map-marker-alt mr-1"></i> Ubicación
                        </label>
                        <input type="text" name="ubicacion" id="ubicacion" value="{{ request('ubicacion') }}"
                            class="mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm">
                    </div>

                    <!-- Campo Rubro -->
                    <div class="flex-grow min-w-0">
                        <label for="rubro_id" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-tags mr-1"></i> Rubro
                        </label>
                        <select name="rubro_id" id="rubro_id"
                            class="mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm">
                            <option value="">Seleccione un rubro</option>
                            @foreach ($rubros as $rubro)
                                <option value="{{ $rubro->id }}"
                                    {{ request('rubro_id') == $rubro->id ? 'selected' : '' }}>
                                    {{ $rubro->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botón de Buscar -->
                    <div class="flex-shrink-0">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:from-indigo-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-700 disabled:opacity-50 transition-all ease-in-out duration-200 shadow-lg">
                            <i class="fas fa-search mr-2"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>


            @if (Auth::user()->hasRole('postulante') || Auth::user()->hasRole('empresa'))
                <div class="mb-4 flex justify-end">
                    @if ($mostrarVencidas)
                        <a href="{{ route('buscar_oferta') }}"
                            class="relative inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-full text-gray-900 bg-gray-200 hover:bg-gray-300 hover:text-red-600 transition-all duration-300 ease-in-out shadow-lg transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-red-600">
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-red-400 to-transparent opacity-0 hover:opacity-30 transition-opacity duration-300 ease-in-out rounded-full"></span>
                            <span class="relative z-10 flex items-center">
                                <i class="fas fa-eye-slash mr-2"></i> Ocultar Ofertas Vencidas
                            </span>
                        </a>
                    @else
                        <a href="{{ route('buscar_oferta', ['vencidas' => true]) }}"
                            class="relative inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-full text-gray-900 bg-gray-200 hover:bg-gray-300 hover:text-blue-600 transition-all duration-300 ease-in-out shadow-lg transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-600">
                            <span
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-blue-400 to-transparent opacity-0 hover:opacity-30 transition-opacity duration-300 ease-in-out rounded-full"></span>
                            <span class="relative z-10 flex items-center">
                                <i class="fas fa-eye mr-2"></i> Ver Ofertas Vencidas
                            </span>
                        </a>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($ofertas as $oferta)
                    @php
                        $esPostulante = Auth::user() && Auth::user()->hasRole('postulante');
                        $esEmpresa = Auth::user() && Auth::user()->hasRole('empresa');
                        $haVencido = $oferta->oferta_disponible_hasta < now();
                        $diasRestantes = floor(now()->diffInDays($oferta->oferta_disponible_hasta, false));
                        $horasRestantes = now()->diffInHours($oferta->oferta_disponible_hasta, false);
                        $limitePostulantesAlcanzado = $oferta->contarPostulantes() >= $oferta->limite_postulantes; // Verificar si se alcanzó el límite de postulantes
                    @endphp

                    @if ($esEmpresa || !$haVencido || ($esPostulante && ($mostrarVencidas || !$haVencido)))
                        <div class="bg-white rounded-lg shadow-md hover:transform hover:scale-105 duration-300 ease-in-out overflow-hidden
                            {{ $limitePostulantesAlcanzado ? 'hover:shadow-red-500 hover:shadow-lg' : 'hover:shadow-xl' }}"> <!-- Aplicamos la sombra roja si se alcanzó el límite -->

                            @if ($oferta->imagen)
                                <img src="{{ asset('storage/' . $oferta->imagen) }}" alt="{{ $oferta->titulo }}"
                                    class="w-full h-40 object-cover" loading="lazy">
                            @else
                                <div class="bg-gray-100 w-full h-40 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-500 text-xl"></i>
                                </div>
                            @endif

                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-800">
                                    <i class="fas fa-briefcase mr-2"></i>{{ $oferta->titulo }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-2"><i class="fas fa-building mr-1"></i>
                                    {{ $oferta->empresa }}</p>
                                <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $oferta->ubicacion }}</p>
                                <p class="mt-3 text-gray-700"><i class="fas fa-file-alt mr-1"></i>
                                    {{ Str::limit($oferta->descripcion, 80) }}</p>

                                <div class="mt-4">
                                    <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded-full">
                                        <i class="fas fa-users mr-2"></i>{{ $oferta->contarPostulantes() }} / {{ $oferta->limite_postulantes }} postulantes
                                    </span>
                                </div>

                                <div class="mt-4">
                                    @if ($diasRestantes > 0)
                                        <span class="flex items-center text-sm text-green-600 font-semibold">
                                            <i class="fas fa-hourglass-half mr-2"></i>
                                            {{ $diasRestantes }} {{ Str::plural('día', $diasRestantes) }} restantes
                                        </span>
                                    @elseif ($diasRestantes === 0 && $horasRestantes > 0)
                                        <span class="flex items-center text-sm text-yellow-600 font-semibold">
                                            <i class="fas fa-hourglass-end mr-2"></i>
                                            Vence en {{ $horasRestantes }} {{ Str::plural('hora', $horasRestantes) }}
                                        </span>
                                    @elseif ($diasRestantes === 0 && $horasRestantes === 0)
                                        <span class="flex items-center text-sm text-yellow-600 font-semibold">
                                            <i class="fas fa-hourglass-end mr-2"></i>
                                            Vence hoy
                                        </span>
                                    @else
                                        <span class="flex items-center text-sm text-red-600 font-semibold">
                                            <i class="fas fa-times-circle mr-2"></i>
                                            Vencido hace {{ abs(floor($diasRestantes)) }}
                                            {{ Str::plural('día', abs($diasRestantes)) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-6 text-right">
                                    <a href="{{ route('ofertas.show', $oferta->id) }}"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-blue-600 text-white text-sm font-medium rounded-md shadow hover:shadow-lg hover:from-indigo-600 hover:to-blue-700 transition-all duration-300 ease-in-out transform hover:scale-105">
                                        <i class="fas fa-eye mr-2 text-xs"></i> Ver detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                        <p class="text-center text-gray-600 text-lg"><i class="fas fa-search-minus mr-2"></i>No se
                            encontraron ofertas laborales que coincidan con tu búsqueda.</p>
                    </div>
                @endforelse
            </div>


            <div class="mt-10">
                {{ $ofertas->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>
