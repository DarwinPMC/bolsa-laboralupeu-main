<!-- resources/views/components/alert.blade.php -->
@props(['type' => 'info'])

<div class="p-4 mb-4 text-sm text-{{ $type === 'warning' ? 'yellow' : ($type === 'danger' ? 'red' : 'blue') }}-700 bg-{{ $type === 'warning' ? 'yellow' : ($type === 'danger' ? 'red' : 'blue') }}-100 rounded-lg" role="alert">
    {{ $slot }}
</div>
