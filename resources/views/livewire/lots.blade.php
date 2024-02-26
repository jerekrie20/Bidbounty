<div>
    <div>
        <x-livewire.forms.form title="Create/Update Lots" action="update" >

            <x-theme.success />

            <div class="mb-4 flex justify-center">

                <x-livewire.forms.input name="title"  input="text"/>
                <x-livewire.forms.select name="status" :data="$status"/>
                <x-livewire.forms.input name="Start Date" input="date"/>
                <x-livewire.forms.input name="End Date" input="date"/>

            </div>

            <div>
                <label for="bio" class="text-xl text-gray-600">Description</label>
                <br>
                <span id="charCount" class="text-center">{{ 255 - strlen($description) }} characters remaining</span>
                <textarea wire:model="description" id="description" class="border-2 w-full h-44"></textarea>
                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="image-upload"  class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        <div wire:loading wire:target="image">Uploading...</div>
                        <input id="image-upload" wire:model="image" type="file" class="hidden" />
                    </div>
                </label>
            </div>

            <div class="flex justify-center">
                <x-forms.submit>Submit</x-forms.submit>
                <x-forms.reset>Reset</x-forms.reset>
            </div>


        </x-livewire.forms.form>
    </div>

    <script>
        const textArea = document.getElementById('description');
        const charCount = document.getElementById('charCount');

        textArea.addEventListener('input', function() {
            let remaining = 255 - this.value.length;
            charCount.textContent = remaining + " characters remaining";
        });
    </script>




</div>
