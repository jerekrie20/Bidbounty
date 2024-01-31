<div>
    <x-livewire.forms.form title="Update Biography" action="save">

        @if(Session::has('success'))
            <div x-data="{ show: true }"
                 x-init="setTimeout(() => show = false, 3000)"
                 x-show="show"
                 class="text-lg text-green-500 text-center" id="success">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="mb-4 flex justify-center ">
            <div class="mr-2 w-full">
                {{-- Image  --}}
                <p class="text-center font-bold text-xl">File Upload</p>
                <label for="image-upload"  class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        <div wire:loading wire:target="image">Uploading...</div>
                        <input id="image-upload" wire:model="image" type="file" class="hidden" />
                </div>
                </label>
            </div>

            <div class="mr-2">
                    <div>
                        <p class="text-center font-bold text-xl">Current Image</p>
                        @if($currentAvatar)
                            <img src="{{ asset('avatars/' . $currentAvatar) }}" alt="{{$currentAvatar}}" class="w-2/3 m-auto">
                        @elseif($image)
                            <img src="{{ $image->temporaryUrl() }}" alt="Image Preview" class="w-2/3 m-auto">
                        @endif
                    </div>
            </div>

            {{-- Default Avatars --}}
            <div>
                <p class="text-center font-bold text-xl">Default Avatars</p>
                @foreach($defaultAvatars as $avatar)
                    <img src="{{ asset('avatars/' . $avatar) }}" wire:click="setDefaultAvatar('{{ $avatar }}')" alt="{{ $avatar }}" class="cursor-pointer w-1/3 h-auto m-auto">
                @endforeach
            </div>

        </div>

        <div>
            <label for="bio" class="text-xl text-gray-600">Tell us about yourself</label>
            <textarea wire:model="bio" id="bio" class="border-2 w-full h-44"></textarea>
            @error('bio') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>


        <div class="flex justify-center">
            <x-forms.submit>Submit</x-forms.submit>

            <x-forms.reset>Reset</x-forms.reset>


        </div>


    </x-livewire.forms.form>
</div>
