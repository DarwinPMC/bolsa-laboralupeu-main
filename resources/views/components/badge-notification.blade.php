<!-- resources/views/components/badge-notification.blade.php -->
@props(['count'])

@if ($count > 0)
    <span class="absolute top-0 right-0 -mt-2 -mr-2 bg-red-600 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">
        {{ $count }}
    </span>
@endif
