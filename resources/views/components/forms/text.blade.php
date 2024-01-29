
@props(['id', 'name', 'placeholder'])

<div class="mb-4 mr-4 w-1/3">
    <label for="{{ $id }}" class="sr-only">{{ ucfirst($name) }}</label>
    <input type="text"
           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error($name) border-red-500 @enderror"
           id="{{ $id }}"
           placeholder="{{ $placeholder }}"
           name="{{ $name }}"
           required value="{{ old($name) }}">
    @error($name)
    <div class="text-red-500 mt-2 text-sm">
        {{ $message }}
    </div>
    @enderror
</div>
