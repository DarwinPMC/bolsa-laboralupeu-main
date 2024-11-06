<!-- resources/views/components/user-profile-card.blade.php -->

<div class="bg-white border border-gray-200 shadow-md rounded-lg p-4 flex flex-col relative">
    <button onclick="showModal({{ $user->id }})" class="absolute top-2 right-2 bg-transparent text-blue-500 hover:text-blue-700">
        <x-icon-symbol name="eye" />
    </button>

    <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('images/default-avatar.png') }}" alt="Foto de {{ $user->name }}" class="w-24 h-24 rounded-full mx-auto mb-4">

    <div class="text-center">
        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
        <p class="text-sm text-gray-500">{{ $user->email }}</p>
        <p class="text-sm text-gray-500">{{ $user->celular }}</p>
        <p class="text-sm text-gray-500">{{ ucfirst($user->rol) }}</p>
    </div>

    <div class="flex mt-auto space-x-2 justify-center pt-4">
        <x-action-button :href="route('usuarios.edit', $user->id)" color="yellow" icon="M4 7h12M4 11h12M4 15h12">
            Editar
        </x-action-button>
        <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="inline delete-form">
            @csrf
            @method('DELETE')
            <x-action-button color="red" icon="M6 18L18 6M6 6l12 12" onclick="return confirm('¿Está seguro de que desea eliminar este usuario?')">
                Eliminar
            </x-action-button>
        </form>
    </div>
</div>
