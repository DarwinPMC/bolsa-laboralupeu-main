<!-- resources/views/components/textarea-field.blade.php -->
@props(['name', 'label' => '', 'rows' => 3, 'placeholder' => '', 'value' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 font-bold mb-2">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
              class="w-full border border-gray-300 rounded-md p-2 @error($name) border-red-500 @enderror"
              placeholder="{{ $placeholder }}">{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
