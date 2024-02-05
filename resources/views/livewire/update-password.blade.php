<div>
    <x-livewire.forms.form title="Update Password" action="updatePassword">

        <x-theme.success />

        <div class="mb-4 flex justify-center">
            <div class="mr-2 w-full">
                <x-livewire.forms.input name="password" input="password" />
            </div>

            <div class="mr-2 w-full">
                <x-livewire.forms.input name="password_confirmation" input="password_confirmation"  placeholder="Repeat your password"/>
            </div>

        </div>


        <div class="flex justify-center">
            <x-forms.submit>Submit</x-forms.submit>

            <x-forms.reset>Reset</x-forms.reset>


        </div>


    </x-livewire.forms.form>

</div>
