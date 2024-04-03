@props(['name', 'input', 'placeholder','value','required' => true])

<div class="mr-2 w-full">
    <label class="text-xl text-gray-600">
        {{ ucwords(str_replace('_', ' ', $name)) }}
        @if($required)
            <span class="text-red-500 text-xs">*Required</span>
        @endif
    </label>
    <br>
    <input
        wire:model="{{ $name }}"
        class="bg-gray-100 border-2 w-full p-4 rounded-lg"
        type="{{ $input ?? 'text' }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value ?? '' }}"
        placeholder="{{ $placeholder ?? '' }}"
    >
    @error($name)
    <p class="text-red-600 text-xs mb-4">{{ $message }}</p>
    @enderror
</div>

