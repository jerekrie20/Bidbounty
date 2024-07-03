@php use Illuminate\Support\Str; @endphp
<div>
    <div>

        <div class="flex justify-evenly items-center mb-4 mt-12">
            <div>
                <label for="search" class="text-white mr-4">Search:</label>
                <input type="text" wire:model.live="search" placeholder="Search..." />
            </div>
            <div>
                <label for="perPage" class="text-white mr-4">Per Page:</label>
                <select wire:model.live="perPage" id="perPage" name="perPage" class="bg-sky-blue text-black text-lg border-2 w-full p-2 rounded-lg">
                    <option value="2">2</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>
        </div>


        <table class="xl:w-2/3 lg:w-full m-auto divide-y divide-gray-200 table-auto">
            <thead>
            <tr>
                @foreach($columns as $column)
                    <th wire:click.prevent="sortField('{{ $column['field'] }}')"
                        class="px-6 py-3 bg-gray-50 text-left cursor-pointer text-blue-600">
                        {{ $column['label'] }}
                        @if ($sortBy === $column['field'])
                            <span>
                                @if ($sortDirection === 'asc')
                                    <svg class="w-4 h-4 inline-block" fill="currentColor" viewBox="0 0 320 512">
                                    <path d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0L160 264.8l96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L177 352.3c-9.2 9.4-24.4 9.4-34 .2z"/>
                                </svg>
                                @else
                                    <svg class="w-4 h-4 inline-block" fill="currentColor" viewBox="0 0 320 512">
                                    <path d="M177 159.7L313 295.7c9.4 9.4 9.4 24.6 0 33.9l-22.6 22.6c-9.4 9.4-24.6 9.4-33.9 0L160 247.2 96.4 343.6c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l136-136c9.2-9.4 24.4-9.4 34-.2z"/>
                                </svg>
                                @endif
                            </span>
                        @endif
                    </th>
                @endforeach
                <th class="px-6 py-3 bg-gray-50">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $index => $item)
                <tr class="{{ $index % 2 == 0 ? 'bg-gray-200' : 'bg-white' }}">
                    @foreach($columns as $column)
                        @php
                         //If field is a time field, format it
                            if($column['field'] === 'start_time' || $column['field'] === 'end_time') {
                                $item[$column['field']] = \Carbon\Carbon::parse($item[$column['field']])->inUserTimezone()->format('h:i A');
                            }
                        @endphp
                        <td class="px-6 py-4">{{ Str::limit($item[$column['field']], 100)  }}</td>
                    @endforeach
                    <td class="flex px-6 py-4">
                        <button wire:click="edit({{ $item['id'] }})"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </button>
                        <button
                            wire:click="remove({{ $item['id'] }})"
                            wire:confirm="Are you sure you want to delete this item?"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach


            </tbody>
        </table>

        <div class="mt-4 mb-32 flex justify-center">
        {{ $data->links() }}
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
