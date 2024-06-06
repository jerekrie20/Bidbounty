<div>
    <h1 class="text-3xl font-bold text-white text-center mt-10 mb-10">Listings</h1>

    <div class="flex justify-between items-center bg-green-950 xl:w-2/3 m-auto">
        <div class="text-white p-4 font-semibold text-xl">
            <h3>Selected Lot: <span class="text-wheat-yellow">@if(!empty($singleLot))
                        {{$singleLot->title}}
                    @endif</span></h3>
        </div>

        <div>
            <select wire:model.live="selectedLot" name="selectedLot" id="selectedLot"
                    class="bg-sky-blue text-black text-lg border-2 w-full p-2 rounded-lg">
                <option value="">Select Lot</option>
                @foreach($lots as $lot)
                    <option value="{{$lot->id}}">{{$lot->title}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        @if(!empty($singleLot))
            <x-livewire.forms.form title="Item Manager" :action="$formAction">
                <x-theme.success/>

                <div class="mb-4 flex justify-center">
                    <input type="hidden" name="lot_id" id="lot_id" value="{{$singleLot->id}}">
                    <div class="mr-2 w-full">
                        <p class="text-xl text-gray-600">Lot: <span
                                class="text-wheat-yellow text-xs">Display Only</span></p>
                        <p class="bg-gray-100 border-2 w-full p-4 rounded-lg">{{$singleLot->id}}
                            - {{$singleLot->title}}</p>
                    </div>
                    <x-livewire.forms.input name="title" type="text"/>
                    <x-livewire.forms.select name="status" :data="$statusOption"/>

                </div>
                <div class="mb-4 flex justify-center">
                    <x-livewire.forms.input name="starting_bid" placeholder="00.00" type="text"/>

                    <div class="mr-2 w-full">
                        <p class="text-xl text-gray-600">Current Bid: <span class="text-wheat-yellow text-xs">Display Only</span>
                        </p>
                        <p class="bg-gray-100 border-2 w-full p-4 rounded-lg"> {{ $current_bid ?? '00.00' }}</p>
                    </div>

                    <x-livewire.forms.input name="reserve_price" placeholder="00.00" type="number"/>

                </div>
                <div class="mb-4 flex justify-center">
                    <div class="mr-2 w-full">
                        <p class="text-xl text-gray-600">Start Date: <span class="text-wheat-yellow text-xs">Display Only</span>
                        </p>
                        <p class="bg-gray-100 border-2 w-full p-4 rounded-lg"> {{ \Carbon\Carbon::parse($singleLot->start_date)->format('Y-m-d h:i A') }}</p>
                    </div>
                    <div class="mr-2 w-full">
                        <p class="text-xl text-gray-600">End Date: <span
                                class="text-wheat-yellow text-xs">Display Only</span></p>
                        <p class="bg-gray-100 border-2 w-full p-4 rounded-lg">{{ \Carbon\Carbon::parse($singleLot->end_date)->format('Y-m-d h:i A') }}</p>
                    </div>
                    <x-livewire.forms.input name="start_time" :required="false" input="time"/>
                    <x-livewire.forms.input name="end_time" :required="false" input="time"/>

                </div>

                <div>
                    <p class="text-soil-brown font-semibold text-sm">** Item auction start/end time MUST be between lot
                        start and end times</p>
                    <p class="text-soil-brown font-semibold text-sm">*** If not time is set on a item, the default start
                        and end time for the lot will be used</p>
                </div>

                <div>
                    <label for="bio" class="text-xl text-gray-600">Description</label>
                    <br>
                    <textarea wire:model="description" id="description" class="border-2 w-full h-44"></textarea>
                    @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <p class="text-center font-bold text-xl mt-2">Bulk File Upload</p>
                    <p class="text-center font-bold text-sm mb-2 text-soil-brown">
                        ** Image are being scaled down to 400x300 <br>
                        *** Aspect ratio of 4:3 is maintained
                    </p>
                    <label for="image-upload"
                           class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold flex justify-center flex-wrap">
                            @if($files)
                                @foreach($files as $file)
                                    {{ $file->getClientOriginalName() }}
                                @endforeach
                            @else
                                Click to upload
                            @endif
                        </span>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF</p>
                            <div wire:loading wire:target="files">Uploading...</div>
                            <input id="image-upload" wire:model="files" multiple type="file" class="hidden"/>
                            @error('files.*')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </label>
                </div>
                <div class="mb-3">
                    <p class="text-center font-bold text-xl mt-2">File Preview</p>
                    <div class="flex justify-center flex-wrap  p-4">
                        @if ($files)
                            @foreach ($files as $index => $file)
                                <img src="{{ $file->temporaryUrl() }}" alt="Image Preview"
                                     class="w-1/3 h-auto object-cover rounded-md p-1 mb-2">
                            @endforeach
                        @elseif(!empty($images))

                            @foreach($images as $image)
                                <img src="{{ asset('items/' . $image) }}" alt="Image Preview"
                                     class="w-1/3 h-auto object-cover rounded-md p-1 mb-2">
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="mb-3 flex justify-center">
                    <button wire:click="$set('showModal', true)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">Select Categories</button>
                </div>
                <div class="flex justify-center">
                    <x-forms.submit>Submit</x-forms.submit>
                    <x-forms.reset>Reset</x-forms.reset>
                </div>

                @if($showModal)
                <div wire:transition.out.opacity.duration.200ms class="fixed top-0 left-0 w-fit h-screen flex items-center justify-center bg-black bg-opacity-50 p-10 z-10">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-xl font-semibold mb-4">Categories</h2>

                        <x-livewire.forms.checkbox model="category" :data="$categories" name="categories" :categoryList="$category"/>

                        <div class="flex justify-end mt-4">
                            <button wire:click.stop="$set('showModal', false)" class="px-4 py-2 rounded mr-2 text-white bg-blue-500 hover:bg-blue-600">Confirm</button>
                            <button wire:click.stop="$set('showModal', false)" class="px-4 py-2 rounded text-gray-600 bg-gray-200 hover:bg-gray-300">Cancel</button>
                        </div>
                    </div>
                </div>
                @endif

            </x-livewire.forms.form>
        @else
            <div class="text-center text-white font-semibold text-xl mt-4 mb-4">
                <h3>Please select a lot to manage items</h3>
            </div>
        @endif

    </div>


    <div>
        @if(!empty($items))
            <livewire:display-data :columns="$columns" :id="$singleLot->id" columnID="lot_id" model="Item"/>
        @endif

    </div>

</div>
