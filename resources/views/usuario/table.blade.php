<!-- resources/views/usuario/table.blade.php -->

<div class="overflow-hidden border border-gray-200 rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100 border-b-2 border-gray-300">
            <tr>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Correo</th>
                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rol</th>
                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($user->rol == 'empresa')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Empresa</span>
                    @elseif($user->rol == 'postulante')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Postulante</span>
                    @elseif($user->rol == 'supervisor')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Supervisor</span>
                    @else
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($user->rol) }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <x-button-icon :href="route('usuarios.show', $user->id)" color="blue" icon="fas fa-eye">Ver</x-button-icon>
                    <x-button-icon :href="route('usuarios.edit', $user->id)" color="yellow" icon="fas fa-edit">Editar</x-button-icon>
                    <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <x-button-icon color="red" icon="fas fa-trash" onclick="return confirm('¿Está seguro de que desea eliminar este usuario?')">Eliminar</x-button-icon>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
