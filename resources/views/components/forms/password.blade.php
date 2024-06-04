@props(['id', 'name', 'placeholder'])

<div class="mb-4 w-full pr-2 pl-2 md:w-1/3">
    <label for="{{ $id }}" class="sr-only">{{ ucfirst($name) }}</label>
    <input type="password"
           class="bg-gray-100 border-2 w-full p-4 rounded-lg @error($name) border-red-500 @enderror"
           id="{{ $id }}"
           placeholder="{{ $placeholder }}"
           name="{{ $name }}" >

    @error($name)
    <div class="text-red-500 mt-2 text-sm">
        {{ $message }}
    </div>
    @enderror
</div>
