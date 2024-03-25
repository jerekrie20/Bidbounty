@props(['model', 'data', 'name', 'categoryList'])

<div class="text-xl text-gray-600">
    <label for="{{ $name }}">
        {{ ucfirst($name) }}
        <span class="text-red-500">*</span>
    </label>
</div>

<div class="form-group flex flex-wrap">
    @foreach($data as $item)
        <div class="form-check p-2">
            <input type="checkbox" class="form-check-input" id="{{ $item->id }}" value="{{ $item->id }}" wire:model="{{ $model }}" {{ in_array($item->id, $categoryList) ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $item->id }}">{{ $item->name }}</label>
        </div>
    @endforeach

    @error($model) <span class="error">{{ $message }}</span> @enderror
</div>
