<!-- resources/views/components/action-button.blade.php -->
@props(['color' => 'blue', 'icon' => '', 'href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => "inline-flex items-center px-4 py-2 bg-$color-500 hover:bg-$color-600 text-white font-bold rounded-lg shadow-md transition ease-in-out duration-150"]) }}>
    @if ($icon)
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path d="{{ $icon }}" />
        </svg>
    @endif
    {{ $slot }}
</a>
