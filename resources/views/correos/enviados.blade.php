<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center">
            <i class="fas fa-paper-plane text-indigo-600 mr-2"></i> {{ __('Correos Enviados') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto hidden sm:block">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-indigo-100 border-b-2 border-indigo-300">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Destinatario</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Fecha de Envío</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Leído</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($correos as $index => $correo)
                            <tr class="{{ $index % 2 == 0 ? 'bg-indigo-50' : 'bg-white' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $correo->destinatario }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $correo->fecha_envio }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="{{ $correo->estado == 'Enviado' ? 'text-green-500 font-semibold' : 'text-red-500 font-semibold' }}">
                                        {{ $correo->estado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($correo->leido)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-200 text-green-800">Leído</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-200 text-red-800">No Leído</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No se han enviado correos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="block sm:hidden">
                @forelse($correos as $correo)
                    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-bold text-gray-900">{{ $correo->destinatario }}</h3>
                            <span class="{{ $correo->estado == 'Enviado' ? 'text-green-500 font-semibold' : 'text-red-500 font-semibold' }}">
                                {{ $correo->estado }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">Fecha de Envío: {{ $correo->fecha_envio }}</p>
                        <p class="mt-1">
                            @if ($correo->leido)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-200 text-green-800">Leído</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-200 text-red-800">No Leído</span>
                            @endif
                        </p>
                    </div>
                @empty
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <p class="text-center text-gray-500">No se han enviado correos.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
