@props(['name','data','itemID'])

<div class="mr-2 w-full">
    <label
        class="text-xl text-gray-600">
        {{ucwords($name)}}

        <span class="text-red-500">*</span></label>

    <br>


    <select name="{{isset($itemID) ? $itemID : $name}}" id="{{isset($itemID) ? $itemID : $name}}" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
        @foreach($data as $item)
            <option
                value="{{$item->id}}" {{isset($user) && $user->$itemID == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
        @endforeach
    </select>

    @error($name)
    <p class="text-red-600 text-xs mb-4">{{$message}}</p>
    @enderror

</div>
