<!-- resources/views/components/button-icon.blade.php -->

@props(['icon', 'tooltip' => '', 'classes' => '', 'href' => null, 'onclick' => null])

@if($href)
    <!-- Enlace para acciones como 'Editar' -->
    <a href="{{ $href }}" class="flex items-center justify-center p-2 rounded {{ $classes }}" title="{{ $tooltip }}">
        <i class="{{ $icon }}"></i>
    </a>
@else
    <!-- Botón para acciones como 'Ver' y 'Eliminar' -->
    <button type="button" @if($onclick) onclick="{{ $onclick }}" @endif class="flex items-center justify-center p-2 rounded {{ $classes }}" title="{{ $tooltip }}">
        <i class="{{ $icon }}"></i>
    </button>
@endif
