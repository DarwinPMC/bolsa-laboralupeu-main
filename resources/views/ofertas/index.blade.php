<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 9.75L12 3l9 6.75M9 21V11.25m6 9.75V11.25M9 21H6.75A2.25 2.25 0 0 1 4.5 18.75V9.75m14.25 0v9a2.25 2.25 0 0 1-2.25 2.25H15" />
            </svg>
            {{ __('Ofertas Laborales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="mb-4 flex items-center space-x-4">
                    <x-buttonusers
                        href="{{ route('ofertas.create') }}"
                        color="bg-green-500"
                        hover="hover:bg-green-600"
                        icon="fas fa-plus"
                        size="w-12 h-12"
                    />

                    <x-buttonusers
                        href="{{ route('ofertas.pendientes') }}"
                        color="bg-yellow-500"
                        hover="hover:bg-yellow-600"
                        icon="fas fa-exclamation-circle"
                        size="w-12 h-12"
                    >
                        Ver Pendientes
                    </x-buttonusers>

                    <form action="{{ route('ofertas.index') }}" method="GET" class="flex items-center space-x-2 w-full">
                        <div class="relative flex-grow">
                            <input
                                name="search"
                                type="text"
                                class="form-input rounded-md shadow-sm block w-full py-2 px-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out placeholder-gray-500 text-gray-700"
                                placeholder="Buscar..."
                                value="{{ request('search') }}"
                                aria-label="Buscar ofertas"
                            />
                            <span class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                        </div>
                        <button
                            type="submit"
                            class="bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-semibold py-1.5 px-4 rounded-md shadow-sm hover:shadow-md transition duration-200 ease-in-out flex items-center space-x-2">
                            Buscar
                        </button>
                    </form>
                </div>

                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                            <thead class="bg-gradient-to-r from-gray-200 via-gray-300 to-gray-400 text-gray-800">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th
                                        class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                        Título
                                    </th>
                                    <th
                                        class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                        Ubicación
                                    </th>
                                    <th
                                        class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                        Publicado
                                    </th>
                                    <th
                                        class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                        Estado
                                    </th>
                                    <th
                                        class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                        Rubro
                                    </th>
                                    <th
                                        class="py-4 px-6 text-left text-sm font-semibold tracking-wider uppercase border-b border-gray-300">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($ofertas as $oferta)
                                    @php
                                        $haVencido = $oferta->oferta_disponible_hasta < now();
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span
                                                class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-500 text-white">
                                                {{ $loop->iteration }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ $oferta->titulo }}
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-500">{{ $oferta->ubicacion }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-500">
                                            {{ $oferta->created_at->format('d-m-Y') }}
                                        </td>
                                        <td class="py-4 px-6 text-sm font-medium cursor-pointer"
                                            onclick="abrirCambioFecha({{ $oferta->id }}, '{{ $oferta->oferta_disponible_hasta ? $oferta->oferta_disponible_hasta->format('Y-m-d') : '' }}')">
                                            @if ($haVencido)
                                                <span class="text-red-500 font-semibold">Vencida</span>
                                            @else
                                                <span class="text-green-500 font-semibold">Activa</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-500">
                                            {{ $oferta->rubro->nombre ?? 'Sin Rubro' }}
                                        </td>
                                        <td class="py-4 px-6 text-sm font-medium">
                                            <div class="flex space-x-4">
                                                <a href="{{ route('ofertas.postulantes', $oferta->id) }}"
                                                    class="flex items-center text-green-500 hover:text-green-700">
                                                    <i class="fas fa-users mr-2"></i>
                                                    <span>{{ $oferta->postulaciones_count }}</span>
                                                </a>

                                                <x-button-icon icon="fas fa-eye" tooltip="Ver"
                                                    classes="text-blue-500 hover:text-blue-700"
                                                    href="{{ route('ofertas.show', $oferta->id) }}" />

                                                <x-button-icon icon="fas fa-edit" tooltip="Editar"
                                                    classes="text-yellow-500 hover:text-yellow-700"
                                                    href="{{ route('ofertas.edit', $oferta->id) }}" />

                                                <x-button-invite :ofertaId="$oferta->id">
                                                </x-button-invite>

                                                <button class="text-red-500 hover:text-red-700"
                                                    onclick="deleteOffer({{ $oferta->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                                <form id="delete-form-{{ $oferta->id }}"
                                                    action="{{ route('ofertas.destroy', $oferta->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="py-4 px-6 text-center text-sm text-gray-500">No hay
                                            ofertas laborales disponibles.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="block sm:hidden">
                    @forelse($ofertas as $oferta)
                        <div class="bg-white shadow-md rounded-lg mb-4 p-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $oferta->titulo }}</h3>
                            <p class="text-gray-500 text-sm mb-2">Ubicación: {{ $oferta->ubicacion }}</p>
                            <p class="text-gray-500 text-sm mb-2">Publicado: {{ $oferta->created_at->format('d-m-Y') }}
                            </p>
                            <p class="text-sm font-medium">
                                Estado:
                                @if ($oferta->oferta_disponible_hasta < now())
                                    <span class="text-red-500 font-semibold">Vencida</span>
                                @else
                                    <span class="text-green-500 font-semibold">Activa</span>
                                @endif
                            </p>
                            <p class="text-gray-500 text-sm mb-2">Rubro: {{ $oferta->rubro->nombre ?? 'Sin Rubro' }}
                            </p>

                            <div class="flex justify-between items-center mt-4">
                                <a href="{{ route('ofertas.postulantes', $oferta->id) }}"
                                    class="flex items-center text-green-500 hover:text-green-700">
                                    <i class="fas fa-users mr-2"></i>{{ $oferta->postulaciones_count }}
                                </a>

                                <div class="flex space-x-4">
                                    <x-button-icon icon="fas fa-eye" tooltip="Ver"
                                        classes="text-blue-500 hover:text-blue-700"
                                        href="{{ route('ofertas.show', $oferta->id) }}" />

                                    <x-button-icon icon="fas fa-edit" tooltip="Editar"
                                        classes="text-yellow-500 hover:text-yellow-700"
                                        href="{{ route('ofertas.edit', $oferta->id) }}" />

                                    <x-button-invite :ofertaId="$oferta->id">
                                    </x-button-invite>

                                    <button class="text-red-500 hover:text-red-700"
                                        onclick="deleteOffer({{ $oferta->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <form id="delete-form-{{ $oferta->id }}"
                                        action="{{ route('ofertas.destroy', $oferta->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center">No hay ofertas laborales disponibles.</p>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $ofertas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    @if(isset($oferta))
    @include('modals.invitar-postulantes', ['ofertaId' => $oferta->id])
@endif
    @vite('resources/js/ofertas.js')

</x-app-layout>
