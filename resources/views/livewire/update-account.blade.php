<div>


<x-livewire.forms.form title="Update Account" action="update" >

    @if(Session::has('success'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 3000)"
             x-show="show"
             class="text-lg text-green-500 text-center" id="success">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="mb-4 flex justify-center">

        <x-livewire.forms.input name="name"  input="text"/>

        <x-livewire.forms.input name="email" input="text"/>

        <x-livewire.forms.input name="phone" input="tel" placeholder="000-000-0000"/>

    </div>

    <div class="mb-4 flex justify-center">

        <x-livewire.forms.input name="address" input="text"/>
        <x-livewire.forms.input name="city" input="text"/>
    </div>

    <div class="mb-4 flex justify-center">
        <x-livewire.forms.select name="state" :data="$states"   itemID="state_id"/>
        <x-livewire.forms.select name="country" :data="$countries" itemID="country_id"/>
        <x-livewire.forms.input name="zip" input="text"/>
    </div>



    <div class="flex justify-center">
        <x-forms.submit>Submit</x-forms.submit>

        <x-forms.reset>Reset</x-forms.reset>


    </div>


</x-livewire.forms.form>
</div>
