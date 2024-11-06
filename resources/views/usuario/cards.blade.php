<!-- resources/views/usuario/cards.blade.php -->

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($users as $user)
    <div class="bg-white border border-gray-200 shadow-md rounded-lg p-4 flex flex-col relative">
        <x-button-icon :href="route('usuarios.show', $user->id)" color="blue" icon="fas fa-eye" class="absolute top-2 right-2">Ver</x-button-icon>

        <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('images/default-avatar.png') }}" alt="Foto de {{ $user->name }}" class="w-24 h-24 rounded-full mx-auto mb-4">
        <div class="text-center">
            <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
            <p class="text-sm text-gray-500">{{ $user->email }}</p>
            <p class="text-sm text-gray-500">{{ ucfirst($user->rol) }}</p>
        </div>
        <div class="flex mt-auto space-x-2 justify-center pt-4">
            <x-button-icon :href="route('usuarios.edit', $user->id)" color="yellow" icon="fas fa-edit">Editar</x-button-icon>
            <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="inline delete-form">
                @csrf
                @method('DELETE')
                <x-button-icon color="red" icon="fas fa-trash" onclick="return confirm('¿Está seguro de que desea eliminar este usuario?')">Eliminar</x-button-icon>
            </form>
        </div>
    </div>
    @endforeach
</div>
