<?php

use App\Models\Lot;
use Livewire\WithPagination;
use function Livewire\Volt\{computed, layout, state, title, usesPagination, with, mount};

usesPagination();

layout('components.layouts.auction');
title('Auctions');

state(['search'])->url();
state(['status'])->url();
state(['category'])->url();
state(['start_date'])->url();
state(['end_date'])->url();
state(['perPage'])->url();

with(fn() => [
    'lots' => Lot::query()
        ->where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        ->when($this->status, fn($query) => $query->where('status', $this->status))
        ->when($this->start_date, fn($query) => $query->where('start_date', '>=', $this->start_date))
        ->when($this->end_date, fn($query) => $query->where('end_date', '<=', $this->end_date))
        ->paginate($this->perPage),
]);

//Reset Filters/search
$resetFilters = fn() => $this->reset(['search', 'status', 'category', 'start_date', 'end_date', 'perPage']);

//Computed Properties
$bgColor = computed(fn() => [
    'upcoming' => 'bg-blue-500',
    'live' => 'bg-green-500',
    'pending' => 'bg-yellow-500',
    'closed' => 'bg-red-500',
]);
?>
<div>

    <h1 class="mt-10 mb-4 text-4xl dark:text-emerald-100 font-bold text-gray-700 pb-4 pt-3 text-center">Auctions</h1>

    <!-- Search Form -->
    <div class="flex justify-between items-center xl:w-2/3 m-auto">
        <div class="p-4 font-semibold">
            <p class="text-3xl dark:text-lavender-purple font-bold text-gray-700 text-center">Filter: </p>
        </div>
        <div class="p-4 font-semibold text-xl">
            <label for="search" class="text-white">Search:</label>
            <input type="text" name="search" wire:model.live.debounce.500ms="search"
                   class="text-rust-orange caret-rust-orange">
        </div>
        <div class="p-4 font-semibold text-xl">
            <!-- date -->
            <label for="start_date" class="text-white">Start Date:</label>
            <input type="date" name="start_date" wire:model.live="start_date"
                   class="text-rust-orange caret-rust-orange">
        </div>
        <div class="p-4 font-semibold text-xl">
            <!-- date -->
            <label for="end_date" class="text-white">End Date:</label>
            <input type="date" name="end_date" wire:model.live="end_date" class="text-rust-orange caret-rust-orange">
        </div>
    </div>

    <div class="flex justify-center items-center xl:w-2/3 m-auto">
        <div class="p-4 font-semibold text-xl">
            <section>
                <select name="status" id="status" wire:model.live="status"
                        class="bg-sky-blue text-black text-lg border-2 w-full p-2 rounded-lg">
                    <option value="">Select Status</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="live">Live</option>
                    <option value="pending">Pending</option>
                    <option value="closed">Closed</option>
                </select>
            </section>
        </div>
        <div class="p-4 font-semibold text-xl">
            <!-- category -->
            <section>
                <select name="category" id="category"
                        class="bg-sky-blue text-black text-lg border-2 w-full p-2 rounded-lg">
                    <option value="">Select Category</option>
                    <option value="art">Art</option>
                    <option value="antiques">Antiques</option>
                    <option value="jewelry">Jewelry</option>
                    <option value="collectibles">Collectibles</option>
                    <option value="furniture">Furniture</option>
                    <option value="home">Home</option>
                    <option value="electronics">Electronics</option>
                    <option value="automotive">Automotive</option>
                    <option value="other">Other</option>
                </select>
            </section>
        </div>

        <div class="p-4 font-semibold text-xl">
            <section>
                <select name="perPage" id="perPage" wire:model.live="perPage"
                        class="bg-sky-blue text-black text-lg border-2 w-full p-2 rounded-lg">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </section>
        </div>

        <div class="p-4 font-semibold text-xl">
            <button wire:click="resetFilters"
                    class="bg-gray-800 text-white text-lg font-bold p-2 rounded-lg">Reset
            </button>
        </div>

    </div>


    <div class="flex flex-col items-center flex-wrap mt-10 m-auto md:flex-row lg:w-3/4">
        @if($lots->isEmpty())
            <div class="w-full p-4 text-center">
                <h1 class="text-2xl font-bold text-white">No Lots Found</h1>
            </div>
        @endif
        @foreach($lots as $lot)
            <a href="/auction/{{ $lot->id }}">

                <div class="w-full md:w-1/2 lg:w-1/3 p-4 hover:cursor-pointer md:h-[40rem]">
                    <div class="bg-white rounded-lg overflow-hidden h-full shadow-lg hover:shadow-wheat-yellow">
                        <div class="relative">
                            <img class="w-full h-auto object-cover object-center"
                                 src="{{ asset($lot->image ? 'lotImages/' . $lot->image : 'lotImages/default.webp') }}"
                                 alt="{{ $lot->title }} Image">
                            <div
                                class="absolute top-0 right-0 p-2 font-bold {{$this->bgColor[$lot->status]}}">{{$lot->status}}</div>
                        </div>
                        <div class="flex justify-between bg-rust-orange font-semibold">
                            <div>
                                <p class="p-2 text-white">{{ \Carbon\Carbon::parse($lot->start_date)->format('Y-m-d') }}</p>
                                <p class="p-2 text-white ">{{ \Carbon\Carbon::parse($lot->end_date)->format('Y-m-d') }}</p>
                            </div>
                            <div>
                                <p class="p-2 text-white"> {{ \Carbon\Carbon::parse($lot->start_date)->format('h:i A') }}</p>
                                <p class="p-2 text-white"> {{ \Carbon\Carbon::parse($lot->end_date)->format('h:i A') }}</p>
                            </div>

                        </div>

                        <div class="flex justify-center mt-2">
                            @foreach($lot->categories as $category)
                                <p class="p-1">{{ $category->name }}</p><i
                                    class="p-2 fa-solid fa-ellipsis-vertical fa-beat text-midnight-blue"></i>
                            @endforeach
                        </div>

                        <div class='p-4 text-center'>
                            <h2 class='text-2xl font-bold text-gray-800'>{{ $lot->title }}</h2>
                            <p class='mt-2 text-gray-600'>{{ $lot->description }}</p>
                        </div>


                        <div class="flex justify-center align-bottom mt-3">
                            <a href=""
                               class=""></a>
                        </div>


                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $lots->links() }}
    </div>
</div>
