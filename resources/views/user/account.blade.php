<x-layouts.user>

    @livewire('update-account')

    @livewire('update-biography')


    <x-forms.form title="Update Password" method="POST" action="/user/account/password">

        <div class="mb-4 flex justify-center">
            <div class="mr-2 w-full">
                <x-forms.input name="password" input="password" />
            </div>

            <div class="mr-2 w-full">
                <label for="password_confirmation" class="text-xl text-gray-600">Password again</label>
                <input type="text" name="password_confirmation" id="password_confirmation"
                       class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('password_confirmation') border-red-500 @enderror"
                       placeholder="Repeat your password">
            </div>

        </div>


        <div class="flex justify-center">
            <x-forms.submit>Submit</x-forms.submit>

            <x-forms.reset>Reset</x-forms.reset>


        </div>


    </x-forms.form>

</x-layouts.user>
