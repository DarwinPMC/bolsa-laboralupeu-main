<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Postulaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                <!-- Mostrar mensajes de éxito o error -->


                <!-- Barra de Búsqueda -->
                <div class="mb-4 flex justify-end items-center">
                    <form action="{{ route('postulaciones.index') }}" method="GET" class="flex items-center w-full max-w-lg">
                        <input name="search" type="text" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Buscar postulaciones..." value="{{ request('search') }}" />
                        <button type="submit" class="ml-2 inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wider hover:from-indigo-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-indigo-700 transition-all ease-in-out duration-200 shadow-lg">
                            Buscar
                        </button>
                    </form>
                </div>


                <!-- Tabla de Postulaciones -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase">#</th>
                                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase">Oferta</th>
                                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase">Empresa</th>
                                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase">Ubicación</th>
                                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase">Fecha de Postulación</th>
                                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase">Estado</th>
                                <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($postulaciones as $index => $postulacion)
                                <tr>
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $postulaciones->firstItem() + $index }}</td>
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $postulacion->oferta->titulo }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-500">{{ $postulacion->oferta->empresa }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-500">{{ $postulacion->oferta->ubicacion }}</td>
                                    <td class="py-4 px-6 text-sm text-gray-500">{{ $postulacion->created_at->format('d M, Y h:i A') }}</td>
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
                                    <td class="py-4 px-6 text-sm font-medium flex space-x-2">
                                        <button onclick="confirmDelete({{ $postulacion->id }})" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>

                                        <!-- El formulario de eliminación -->
                                        <form id="delete-form-{{ $postulacion->id }}" action="{{ route('postulaciones.destroy', $postulacion->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 px-6 text-center text-sm text-gray-500">No hay postulaciones disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $postulaciones->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Script de confirmación con SweetAlert -->
    <script>
        function confirmDelete(postulacionId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + postulacionId).submit();
                }
            });
        }
    </script>

</x-app-layout>
