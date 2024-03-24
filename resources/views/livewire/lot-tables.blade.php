<div class="w-full overflow-x-auto"> {{-- For horizontal scrolling on smaller screens --}}
    <div class="flex items-center mb-4">
        <label for="search" class="text-gray-600 mr-4">Search:</label>
        <input type="text" id="search" wire:model.debounce.500ms="search" class="border-2 border-gray-300">
    </div>

    <table class="min-w-full divide-y divide-gray-200 table-auto">
        <thead>
        <tr>
            <th wire:click="sortBy('title')" class="px-6 py-3 bg-gray-50 text-left">
                Title
                {{-- Add sorting icons if desired --}}
            </th>
            <th wire:click="sortBy('description')" class="px-6 py-3 bg-gray-50 text-left">
                Description
            </th>
            <th wire:click="sortBy('created_at')" class="px-6 py-3 bg-gray-50 text-left">
                Created At
            </th>
            {{-- More columns as needed --}}
            <th class="px-6 py-3 bg-gray-50">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($lots as $lot)
            <tr>
                <td class="px-6 py-4">{{ $lot->title }}</td>
                <td class="px-6 py-4">{{ $lot->description }}</td>
                <td class="px-6 py-4">{{ $lot->created_at->format('Y-m-d') }}</td>
                {{-- Use Tailwind to align content if needed --}}
                <td class="px-6 py-4 flex justify-start">
                    {{-- Edit, View, Delete buttons here --}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $lots->links() }} {{-- Tailwind-ready pagination --}}
    </div>
</div>
