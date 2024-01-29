<x-layouts.user>

    <x-forms.form title="Update Account" method="POST" action="/user/account">
        <div class="mb-4 flex justify-center">

            <x-forms.input name="name" input="text" :data="isset($user) ? $user->name : ''"/>

            <x-forms.input name="email" input="text" :data="isset($user) ? $user->email : ''"/>

            <x-forms.input name="phone" input="tel" :data="isset($user) ? $user->phone : ''"/>
        </div>

        <div class="mb-4 flex justify-center">
                <x-forms.input name="address" input="text" :data="isset($user) ? $user->address : ''"/>

                <x-forms.input name="city" input="text" :data="isset($user) ? $user->city : ''"/>
        </div>

        <div class="mb-4 flex justify-center">
            <x-forms.select name="state" :data="$states" itemID="state_id"/>
            <x-forms.select name="country" :data="$countries" itemID="country_id"/>
            <x-forms.input name="zip" input="text" :data="isset($user) ? $user->zip : ''"/>
        </div>



        <div class="flex justify-center">
                <x-forms.submit>Submit</x-forms.submit>

                <x-forms.reset>Reset</x-forms.reset>


        </div>


    </x-forms.form>

    <x-forms.form title="Update Biography" method="POST" action="/user/account/bio">

        <div class="mb-4 flex justify-center ">
            <div class="mr-2 w-full">
                {{-- Image  --}}
                <x-forms.file />


            </div>

            <div class="mr-2">

                @if(!empty($user->image))
                    <div>
                        <p class="text-center font-bold text-xl">Current Image</p>
                        <img id="currentAvatar" src="{{asset('avatars/'. $user->image)}}" alt="" class="w-1/2 h-auto ml-24">
                    </div>
                @endif
            </div>

            <x-forms.defaultAvatar :avatars="$defaultAvatars" />

        </div>

        <div>
            <label for="bio" class="text-xl text-gray-600">Tell us about yourself</label>
            <textarea name="bio" id="bio" class="border-2 w-full h-44"></textarea>
        </div>


        <div class="flex justify-center">
            <x-forms.submit>Submit</x-forms.submit>

            <x-forms.reset>Reset</x-forms.reset>


        </div>


    </x-forms.form>


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
