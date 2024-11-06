@props(['href' => '#', 'color' => 'bg-green-500', 'hover' => 'hover:bg-green-600', 'icon' => '', 'size' => 'w-10 h-10'])

<a href="{{ $href }}" class="{{ $color }} {{ $hover }} text-white font-bold p-2 rounded-full inline-flex items-center justify-center {{ $size }}">
    @if($icon)
        <i class="{{ $icon }}"></i>
    @endif
</a>
