@props(['name', 'data', 'itemID'])

<div class="mr-2 w-full">
    <label class="text-xl text-gray-600">
        {{ ucwords($name) }}
        <span class="text-red-500">*</span>
    </label>
    <br>
    @if(!empty($itemID))
        <select wire:model="{{$itemID}}" name="{{$itemID}}" id="{{$itemID}}" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
            <option value="">Select {{ ucwords($name) }}</option>
            @foreach($data as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
            @endforeach
        </select>
        @error($itemID)
        <p class="text-red-600 text-xs mb-4">{{$message}}</p>
        @enderror
    @else

        <select wire:model="{{$name}}" name="{{$name}}" id="{{$name}}" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
            <option value="">Select {{ ucwords($name) }}</option>
            @foreach($data as $item)
                <option value="{{$item}}">{{$item}}</option>
            @endforeach

        </select>
        @error($name)
        <p class="text-red-600 text-xs mb-4">{{$message}}</p>
        @enderror
    @endif






</div>

