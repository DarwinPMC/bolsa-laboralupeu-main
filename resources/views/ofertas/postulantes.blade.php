<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Postulantes para ') }} <span class="text-blue-600">{{ $oferta->titulo }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                @if($postulaciones->isEmpty())
                    <p class="text-gray-600 text-center text-lg">No hay postulantes para esta oferta laboral.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg shadow">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700 uppercase">Nombre</th>
                                    <th class="py-3 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700 uppercase">Correo</th>
                                    <th class="py-3 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700 uppercase">Fecha de Postulación</th>
                                    <th class="py-3 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700 uppercase">CV</th>
                                    <th class="py-3 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700 uppercase">Estado</th>
                                    <th class="py-3 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($postulaciones as $postulacion)
                                <tr class="border-b border-gray-200 hover:bg-gray-100 transition">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $postulacion->usuario->name }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-500">{{ $postulacion->usuario->email }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-500">{{ $postulacion->created_at->format('d M, Y h:i:s A') }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-500">
                                        @if($postulacion->usuario->archivo_cv)
                                            <a href="{{ asset('storage/' . $postulacion->usuario->archivo_cv) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-file-alt"></i> Ver CV
                                            </a>
                                        @else
                                            <span class="text-gray-500">No disponible</span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-sm font-medium">
                                        @if($postulacion->estado == 'aceptado')
                                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Aceptado
                                            </span>
                                        @elseif($postulacion->estado == 'rechazado')
                                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rechazado
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-sm font-medium">
                                        <div class="flex space-x-4">
                                            @if($postulacion->estado == 'pendiente')
                                                <button id="aceptar-btn-{{ $postulacion->id }}" onclick="confirmarAceptar({{ $postulacion->id }})" class="text-green-500 hover:text-green-700">
                                                    <i class="fas fa-check"></i> Aceptar
                                                </button>

                                                <button id="rechazar-btn-{{ $postulacion->id }}" onclick="confirmarRechazar({{ $postulacion->id }})" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-times"></i> Rechazar
                                                </button>
                                            @endif

                                            @if($postulacion->estado == 'aceptado' || $postulacion->estado == 'rechazado')
                                                <button id="cancelar-btn-{{ $postulacion->id }}" onclick="confirmarCancelar({{ $postulacion->id }})" class="text-yellow-500 hover:text-yellow-700">
                                                    <i class="fas fa-undo"></i> Cancelar
                                                </button>
                                            @endif

                                            <form id="aceptar-form-{{ $postulacion->id }}" action="{{ route('postulantes.aceptar', $postulacion->id) }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>

                                            <form id="rechazar-form-{{ $postulacion->id }}" action="{{ route('postulantes.rechazar', $postulacion->id) }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>

                                            <form id="cancelar-form-{{ $postulacion->id }}" action="{{ route('postulantes.pendiente', $postulacion->id) }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $postulaciones->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmarAceptar(postulacionId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Aceptarás a este postulante. Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('aceptar-form-' + postulacionId).submit();
                }
            });
        }

        function confirmarRechazar(postulacionId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Rechazarás a este postulante. Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, rechazar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('rechazar-form-' + postulacionId).submit();
                }
            });
        }

        function confirmarCancelar(postulacionId) {
            Swal.fire({
                title: '¿Estás seguro de cancelar la acción?',
                text: "El postulante volverá a estado pendiente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancelar-form-' + postulacionId).submit();
                }
            });
        }
    </script>

</x-app-layout>
