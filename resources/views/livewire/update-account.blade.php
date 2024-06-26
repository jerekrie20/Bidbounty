<div>


<x-livewire.forms.form title="Update Account" action="update" >

    <x-theme.success />

    <div class="mb-4 flex justify-center">

        <x-livewire.forms.input name="name"  input="text"/>

        <x-livewire.forms.input name="email" input="text"/>

        <x-livewire.forms.input name="phone" input="tel" placeholder="000-000-0000"/>

    </div>

    <div class="mb-4 flex justify-center">

        <x-livewire.forms.input name="address" input="text"/>
        <x-livewire.forms.input name="city" input="text"/>
        <x-livewire.forms.select name="state" :data="$states"   itemID="state_id"/>
    </div>

    <div class="mb-4 flex justify-center">

        <div class="mr-2 w-full">
            <label class="text-xl text-gray-600">
                Country
                <span class="text-red-500">*</span>
            </label>
            <br>
                <select wire:model.live="country_id" name="country_id" id="country_id" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                    <option value="">Select Country</option>
                    @foreach($countries as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                @error('country_id')
                <p class="text-red-600 text-xs mb-4">{{$message}}</p>
                @enderror
        </div>

        <div class="mr-2 w-full">
            <label class="text-xl text-gray-600">
                Timezone
                <span class="text-red-500">*</span>
            </label>
            <br>
            <select wire:model="timezone" name="timezone" id="timezone" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                <option value="">Select Timezone</option>
                @foreach($this->timezones() as $zones)
                    <option value="{{$zones}}">{{$zones}}</option>
                @endforeach
            </select>
            @error('timezone')
            <p class="text-red-600 text-xs mb-4">{{$message}}</p>
            @enderror
        </div>


        <x-livewire.forms.input name="zip" input="text"/>
    </div>



    <div class="flex justify-center">
        <x-forms.submit>Submit</x-forms.submit>

        <x-forms.reset>Reset</x-forms.reset>


    </div>


</x-livewire.forms.form>

{{--    @if(!empty($country))--}}
{{--        @foreach($this->timezones() as $zones)--}}
{{--            <div class="mb-4 flex justify-center">--}}
{{--                <x-livewire.forms.input name="timezone" input="text" value="{{$zones}}"/>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    @endif--}}
</div>
