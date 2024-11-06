<!-- resources/views/components/select-field.blade.php -->
@props(['name', 'label' => '', 'options' => []])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 font-bold mb-2">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="w-full border border-gray-300 rounded-md p-2 @error($name) border-red-500 @enderror">
        {{ $slot }} <!-- Permite opciones dinámicas dentro del select -->
    </select>
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
