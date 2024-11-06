@props(['ofertaId'])

<button
    class="text-purple-500 hover:text-purple-700 flex items-center"
    onclick="abrirInvitarModal({{ $ofertaId }})"
    title="Invitar Postulantes"
>
    <i class="fas fa-envelope mr-2"></i>
    {{ $slot }}
</button>
