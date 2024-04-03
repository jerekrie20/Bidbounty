<div>
    <div>
        <x-livewire.forms.form title="Manage Lots" :action="$formAction">

            <x-theme.success/>

            <div class="mb-4 flex justify-center">

                <x-livewire.forms.input name="title" input="text"/>
                <x-livewire.forms.select name="status" :data="$statusOption"/>
            </div>

            <div class="mb-4 flex justify-center">
                <x-livewire.forms.input name="start_date" input="datetime-local"/>
                <x-livewire.forms.input name="end_date" input="datetime-local"/>
            </div>

            <div class="mb-4">
                <x-livewire.forms.checkbox model="category" :data="$categories" name="categories" :categoryList="$category"/>
            </div>

            <div>
                <label for="bio" class="text-xl text-gray-600">Description</label>
                <br>
                <span id="charCount" class="text-center">{{ 500 - strlen($description) }} characters remaining</span>
                <textarea wire:model="description" id="description" class="border-2 w-full h-44"></textarea>
                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <p class="text-center font-bold text-xl">File Upload</p>
                <label for="image-upload"
                       class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold">
                            @if($image)
                                {{ $image->getClientOriginalName() }}
                            @else
                                Click to upload
                            @endif
                        </span>
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        <input id="image-upload" wire:model="image" type="file" class="hidden"/>
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

        textArea.addEventListener('input', function () {
            let remaining = 500 - this.value.length;
            charCount.textContent = remaining + " characters remaining";
        });
    </script>

    <div class="w-full pl-2 pr-2 m-auto overflow-x-auto mt-6"> {{-- For horizontal scrolling --}}
        <div class="flex justify-evenly items-center mb-4">
            <div>
                <label for="search" class="text-white mr-4">Search:</label>
                <input type="text" id="search" wire:model.live.debounce.500ms="search">
            </div>
            <div>
                <label for="perPage" class="text-white mr-4">Per Page:</label>
                <select id="perPage" wire:model.live="perPage" class="bg-gray-800 text-white">
                    <option>5</option>
                    <option>10</option>
                    <option>15</option>
                    <option>20</option>
                </select>
            </div>
            <div class="mt-4 mr-4 flex justify-center">
                {{ $lots->links() }}
            </div>
        </div>



        <table class="xl:w-2/3 lg:w-full m-auto divide-y divide-gray-200 table-auto">
            <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50">Image</th>
                <th class="align-middle px-6 py-3 bg-gray-50 text-blue-600 cursor-pointer" id="title-column"
                    wire:click.prevent="sortField('title')">
                    Title
                    @if ($sortBy === 'title')
                        <span>
                    @if ($sortDirection === 'asc')
                                <svg class="w-4 h-4 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 320 512">
                        <path
                            d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0L160 264.8l96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L177 352.3c-9.2 9.4-24.4 9.4-34 .2z"/>
                    </svg>
                            @else
                                <svg class="w-4 h-4 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 320 512">
                    <path
                        d="M177 159.7L313 295.7c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 247.2 96.4 343.6c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l136-136 .4-.2c9.4-9.4 24.6-9.2 34-.2z"/>
                </svg>
                            @endif
                </span>
                    @endif
                </th>

                <th id="description-column" wire:click.prevent="sortField('description')"
                    class="px-6 py-3 bg-gray-50 text-left cursor-pointer text-blue-600">
                    Description
                    @if ($sortBy === 'description')
                        <span>
                    @if ($sortDirection === 'asc')
                                <svg class="w-4 h-4 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 320 512">
                        <path
                            d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0L160 264.8l96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L177 352.3c-9.2 9.4-24.4 9.4-34 .2z"/>
                    </svg>
                            @else
                                <svg class="w-4 h-4 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 320 512">
                    <path
                        d="M177 159.7L313 295.7c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 247.2 96.4 343.6c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l136-136 .4-.2c9.4-9.4 24.6-9.2 34-.2z"/>
                </svg>
                            @endif
        </span>
                    @endif
                </th>
                <th wire:click.prevent="sortField('start_date')" class="px-6 py-3 bg-gray-50 text-left cursor-pointer text-blue-600">
                    Start Date
                    @if ($sortBy === 'start_date')
                        <span>
                    @if ($sortDirection === 'asc')
                                <svg class="w-4 h-4 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 320 512">
                        <path
                            d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0L160 264.8l96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L177 352.3c-9.2 9.4-24.4 9.4-34 .2z"/>
                    </svg>
                            @else
                                <svg class="w-4 h-4 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 320 512">
                    <path
                        d="M177 159.7L313 295.7c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 247.2 96.4 343.6c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l136-136 .4-.2c9.4-9.4 24.6-9.2 34-.2z"/>
                </svg>
                            @endif
        </span>
                    @endif
                </th>
                <th wire:click.prevent="sortField('end_date')" class="px-6 py-3 bg-gray-50 text-left cursor-pointer text-blue-600">
                    End Date
                    @if ($sortBy === 'end_date')
                        <span>
                    @if ($sortDirection === 'asc')
                                <svg class="w-4 h-4 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 320 512">
                        <path
                            d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0L160 264.8l96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L177 352.3c-9.2 9.4-24.4 9.4-34 .2z"/>
                    </svg>
                            @else
                                <svg class="w-4 h-4 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 320 512">
                    <path
                        d="M177 159.7L313 295.7c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 247.2 96.4 343.6c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l136-136 .4-.2c9.4-9.4 24.6-9.2 34-.2z"/>
                </svg>
                            @endif
        </span>
                    @endif
                </th>
                <th wire:click.prevent="sortField('status')" class="px-6 py-3 bg-gray-50 text-left cursor-pointer text-blue-600">
                    Status
                    @if ($sortBy === 'status')
                        <span>
                    @if ($sortDirection === 'asc')
                                <svg class="w-4 h-4 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 320 512">
                        <path
                            d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0L160 264.8l96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L177 352.3c-9.2 9.4-24.4 9.4-34 .2z"/>
                    </svg>
                            @else
                                <svg class="w-4 h-4 inline-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 320 512">
                    <path
                        d="M177 159.7L313 295.7c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 247.2 96.4 343.6c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l136-136 .4-.2c9.4-9.4 24.6-9.2 34-.2z"/>
                </svg>
                            @endif
        </span>
                    @endif
                </th>
{{--                <th class="px-6 py-3 bg-gray-50">Categories</th>--}}
                <th class="px-6 py-3 bg-gray-50">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($lots as $index => $lot)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-200' : 'bg-white' }}">
                    <td class="px-6 py-4">
                        <img src="{{ asset('lotImages/' . $lot->image)  }}" alt="{{ $lot->title }}" class="w-10 h-10">
                    </td>
                    <td class="px-6 py-4">{{ $lot->title }}</td>
                    <td class="px-6 py-4">{{ \Illuminate\Support\Str::limit($lot->description, 100) }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($lot->start_date)->format('Y-m-d h:i A') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($lot->end_date)->format('Y-m-d h:i A') }}</td>
                    <td class="px-6 py-4">
        <span class="text-lg pl-2 pr-2 pt-4 pb-4 {{
                    $lot->status == 'upcoming' ? 'bg-blue-200 text-blue-800' :
                    ($lot->status == 'live' ? 'bg-green-200 text-green-800' :
                    ($lot->status == 'pending' ? 'bg-yellow-200 text-yellow-800' :
                    ($lot->status == 'closed' ? 'bg-red-200 text-red-800' : 'text-gray-600 dark:text-gray-300')))
                }}">
                    {{ $lot->status }}
                </span>
                    </td>
{{--                    <td class="px-6 py-4">--}}
{{--                        @foreach($lot->categories as $category)--}}
{{--                            <span class="text-md">--}}
{{--                                {{ $category->name }}--}}
{{--                            </span>--}}
{{--                        @endforeach--}}
{{--                    </td>--}}
                    <td class="flex px-6 py-4">
                        <button wire:click="edit({{ $lot->id }})"
                                class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-sm px-3 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                            Edit
                        </button>
                        <button wire:click="delete({{ $lot->id }})"
                                class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-sm px-3 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                                wire:confirm.prompt="Are you sure? This will delete ALL listings under this lot\n\nType YES to confirm|YES">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4 mb-32 flex justify-center">
            {{ $lots->links(data: ['scrollTo' => false])}}
        </div>


    </div>

    @script
    <script>
        Livewire.on('scrollToTop', function() {
            window.scrollTo({ top: 20, behavior: 'smooth' })
        });
    </script>

    @endscript


</div>
