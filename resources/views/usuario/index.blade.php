<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <i class="fas fa-users text-indigo-600 text-3xl"></i>  <!-- Icono de usuarios -->
                <div>
                    <h2 class="text-4xl font-extrabold text-gray-800 leading-tight">
                        {{ __('Lista de Usuarios') }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ __('Gestiona los usuarios registrados en la plataforma') }}
                    </p>
                </div>
            </div>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <form action="{{ route('usuarios.index') }}" method="GET" class="flex items-center space-x-4">
                            <div class="w-full relative">
                                <input type="text" name="search" id="search" placeholder="Buscar..."
                                    class="w-full border border-gray-300 rounded-md p-2 pl-10 pr-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ request()->get('search') }}">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="absolute left-3 top-3 h-5 w-5 text-blue-500" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.9 14.32A7.99 7.99 0 1116 8a8 8 0 01-3.1 6.32l4.1 4.1a1 1 0 01-1.4 1.4l-4.1-4.1zM14 8a6 6 0 11-12 0 6 6 0 0112 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <select name="rol" id="rol" class="border border-gray-300 rounded-md p-2">
                                <option value="">Todos los Roles</option>
                                <option value="admin" {{ request()->get('rol') == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="empresa" {{ request()->get('rol') == 'empresa' ? 'selected' : '' }}>
                                    Empresa</option>
                                <option value="postulante"
                                    {{ request()->get('rol') == 'postulante' ? 'selected' : '' }}>Postulante</option>
                                <option value="supervisor"
                                    {{ request()->get('rol') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                            </select>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg">
                                Buscar
                            </button>

                        </form>
                    </div>

                    <div class="mb-4 flex space-x-2">
                        <x-buttonusers href="{{ route('usuarios.create') }}" color="bg-green-500"
                            hover="hover:bg-green-600" icon="fas fa-user-plus">
                            Crear Nuevo Usuario
                        </x-buttonusers>

                        <x-buttonusers href="{{ route('usuarios.pending') }}" color="bg-orange-500"
                            hover="hover:bg-orange-600" icon="fas fa-users-cog" :counter="$pendingUsersCount">
                            Usuarios Pendientes
                        </x-buttonusers>
                    </div>

                    <div class="mb-4 flex justify-end">
                        <form method="GET" action="{{ route('usuarios.index') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="rol" value="{{ request('rol') }}">
                            <input type="hidden" name="view"
                                value="{{ request('view') == 'table' ? 'grid' : 'table' }}">
                            <button type="submit"
                                class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                {{ request('view') == 'grid' ? 'Ver como Tabla' : 'Ver como Tarjetas' }}
                            </button>
                        </form>
                    </div>

                    @if (request('view') == 'grid')
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach ($users as $user)
                                <div
                                    class="bg-white border border-gray-200 shadow-md rounded-lg p-4 flex flex-col relative">
                                    <x-button-icon icon="fas fa-eye" tooltip="Ver más"
                                        classes="absolute top-2 right-2 bg-transparent text-blue-500 hover:text-blue-700"
                                        onclick="showModal({{ $user->id }})" />

                                    <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('images/default-avatar.png') }}"
                                        alt="Foto de {{ $user->name }}" class="w-24 h-24 rounded-full mx-auto mb-4">

                                    <div class="text-center">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->celular }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->rol }}</p>
                                    </div>

                                    <div class="flex mt-auto space-x-2 justify-center pt-4">
                                        <x-button-icon icon="fas fa-edit" tooltip="Editar"
                                            classes="bg-yellow-500 hover:bg-yellow-700 text-white"
                                            href="{{ route('usuarios.edit', $user->id) }}" />

                                        <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <x-button-icon icon="fas fa-trash" tooltip="Eliminar"
                                                classes="bg-red-500 hover:bg-red-700 text-white"
                                                onclick="if(confirm('¿Está seguro de que desea eliminar este usuario?')) { this.closest('form').submit(); }" />
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="overflow-hidden border border-gray-200 rounded-lg shadow">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100 border-b-2 border-gray-300">
                                    <tr>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            #
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Correo
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Rol
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gradient-to-r from-indigo-500 to-blue-600 text-white font-bold">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($user->rol == 'empresa')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Empresa
                                                    </span>
                                                @elseif($user->rol == 'postulante')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Postulante
                                                    </span>
                                                @elseif($user->rol == 'supervisor')
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                        Supervisor
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ ucfirst($user->rol) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="inline-flex space-x-2">
                                                    <x-button-icon icon="fas fa-eye" tooltip="Ver más"
                                                        classes="bg-blue-500 hover:bg-blue-700 text-white"
                                                        onclick="showModal({{ $user->id }})" />
                                                    <x-button-icon icon="fas fa-edit" tooltip="Editar"
                                                        classes="bg-yellow-500 hover:bg-yellow-700 text-white"
                                                        href="{{ route('usuarios.edit', $user->id) }}" />
                                                    <form action="{{ route('usuarios.destroy', $user->id) }}"
                                                        method="POST" class="inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-button-icon icon="fas fa-trash" tooltip="Eliminar"
                                                            classes="bg-red-500 hover:bg-red-700 text-white"
                                                            onclick="if(confirm('¿Está seguro de que desea eliminar este usuario?')) { this.closest('form').submit(); }" />
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="mt-4">
                        {{ $users->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="userModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-lg w-full p-6">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">Información del Usuario</h3>
                <button onclick="closeModal()" class="text-gray-600 hover:text-gray-900">&times;</button>
            </div>
            <div class="mt-4">
                <p><strong>Nombre:</strong> <span id="modalName"></span></p>
                <p><strong>DNI:</strong> <span id="modalDNI"></span></p>
                <p><strong>RUC:</strong> <span id="modalRUC"></span></p>
                <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                <p><strong>Correo Alternativo:</strong> <span id="modalCorreo"></span></p>
                <p><strong>Celular:</strong> <span id="modalCelular"></span></p>
                <p><strong>Rol:</strong> <span id="modalRol"></span></p>
                <p><strong>Archivo CV:</strong> <a href="#" id="modalCV" target="_blank"
                        class="text-blue-500">Ver CV</a></p>
            </div>
            <div class="mt-4 flex justify-end">
                <button onclick="closeModal()"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        const users = @json($users);

        function showModal(userId) {
            const user = users.data.find(u => u.id === userId);
            if (user) {
                document.getElementById('modalName').innerText = user.name;
                document.getElementById('modalDNI').innerText = user.dni || 'N/A';
                document.getElementById('modalRUC').innerText = user.ruc || 'N/A';
                document.getElementById('modalEmail').innerText = user.email;
                document.getElementById('modalCorreo').innerText = user.correo || 'N/A';
                document.getElementById('modalCelular').innerText = user.celular || 'N/A';
                document.getElementById('modalRol').innerText = user.rol;
                document.getElementById('modalCV').href = user.archivo_cv ? "{{ asset('storage/') }}" + '/' + user
                    .archivo_cv : '#';
                document.getElementById('modalCV').innerText = user.archivo_cv ? 'Ver CV' : 'No disponible';

                document.getElementById('userModal').classList.remove('hidden');
                document.getElementById('userModal').classList.add('flex');
            }
        }

        function closeModal() {
            document.getElementById('userModal').classList.add('hidden');
            document.getElementById('userModal').classList.remove('flex');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');
                    if (confirm('¿Está seguro de que desea eliminar este usuario?')) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
