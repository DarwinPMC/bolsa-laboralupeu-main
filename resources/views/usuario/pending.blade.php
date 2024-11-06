<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuarios Pendientes de Aprobación') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                <!-- Alternar entre vista de tarjetas y tabla -->
                <div class="flex justify-between items-center mb-6">
                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('usuarios.pending') }}" class="w-full max-w-lg">
                        <div class="flex space-x-4">
                            <div class="w-full relative">
                                <x-input id="search" class="block w-full pl-10 pr-3 py-2 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                type="text" name="search" :value="request('search')" placeholder="Buscar por nombre o correo..." />

                                <!-- Cambiar el color del ícono a azul -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-3 h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.9 14.32A7.99 7.99 0 1116 8a8 8 0 01-3.1 6.32l4.1 4.1a1 1 0 01-1.4 1.4l-4.1-4.1zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd" />
                                </svg>
                            </div>

                            <div>
                                <select id="rol" name="rol" class="block w-full form-select border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Todos los roles</option>
                                    <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="empresa" {{ request('rol') == 'empresa' ? 'selected' : '' }}>Empresa</option>
                                    <option value="postulante" {{ request('rol') == 'postulante' ? 'selected' : '' }}>Postulante</option>
                                    <option value="supervisor" {{ request('rol') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                </select>
                            </div>
                            <div>
                                <x-button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                                    {{ __('Buscar') }}
                                </x-button>
                            </div>
                        </div>
                    </form>

                    <!-- Botón para alternar entre vista de tarjetas y vista de tabla -->
                    <div>
                        <form method="GET" action="{{ route('usuarios.pending') }}">
                            <input type="hidden" name="view" value="{{ request('view') == 'table' ? 'grid' : 'table' }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="rol" value="{{ request('rol') }}">
                            <x-button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg ml-4">
                                {{ request('view') == 'grid' ? 'Ver como Tabla' : 'Ver como Tarjetas' }}
                            </x-button>

                        </form>
                    </div>
                </div>

                <!-- Condicional para Vista en Tabla o Tarjetas -->
                @if(request('view') == 'grid')
                    <!-- Vista en tarjetas -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($users as $user)
                        <div class="bg-white border border-gray-200 shadow-md rounded-lg p-4 flex flex-col">
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($user->rol) }}</p>
                            </div>

                            <!-- Botón para aprobar usuario -->
                            <div class="flex mt-auto space-x-2 justify-center pt-4">
                                <form action="{{ route('usuarios.approve', ['id' => $user->id, 'view' => request('view'), 'search' => request('search'), 'rol' => request('rol')]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <x-button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                                        Aprobar
                                    </x-button>

                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- Vista en tabla (por defecto) -->
                    <div class="overflow-hidden border border-gray-200 rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                    <!-- Números con fondo azul y diseño circular -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-500 text-white">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>

                                    <!-- Nombre -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>

                                    <!-- Correo -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>

                                    <!-- Columna Rol con colores -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->rol == 'empresa')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Empresa
                                            </span>
                                        @elseif($user->rol == 'postulante')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Postulante
                                            </span>
                                        @elseif($user->rol == 'supervisor')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                Supervisor
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($user->rol) }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Botón para aprobar usuario -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('usuarios.approve', ['id' => $user->id, 'view' => request('view'), 'search' => request('search'), 'rol' => request('rol')]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <x-button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                                                Aprobar
                                            </x-button>

                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- Enlaces de paginación -->
                <div class="mt-4">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
