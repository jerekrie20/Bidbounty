<?php

use App\Models\Lot;
use Livewire\WithPagination;
use function Livewire\Volt\{computed, layout, state, title, usesPagination, with, mount};

usesPagination();

layout('components.layouts.auction');
title('Auctions');

state(['search'])->url();
state(['status'])->url();
state(['category' => []])->url();
state(['start_date'])->url();
state(['end_date'])->url();
state(['perPage'])->url();
state(['categoryList'])->url();

state('show', false);

$dropdown = fn() => $this->show = !$this->show;

with(fn() => [
    'lots' => Lot::query()
        ->where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        ->where('status', '!=', 'closed')
        ->when($this->status, fn($query) => $query->where('status', $this->status))
        ->when($this->category, fn($query) => $query->whereHas('categories', fn($q) => $q->whereIn('id', $this->category)))
        ->when($this->start_date, fn($query) => $query->where('start_date', '>=', $this->start_date))
        ->when($this->end_date, fn($query) => $query->where('end_date', '<=', $this->end_date))
        ->paginate($this->perPage),

    'categories' => \App\Models\AuctionCategory::all(),
]);

// Reset Filters/search
$resetFilters = fn() => $this->reset(['search', 'status', 'category', 'start_date', 'end_date', 'perPage','categoryList']);

// Computed Properties
$bgColor = computed(fn() => [
    'upcoming' => 'bg-blue-500',
    'live' => 'bg-green-500',
    'pending' => 'bg-yellow-500',
    'closed' => 'bg-red-500',
]);
?>

<div x-data="{ show: @entangle('show') }" >
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
                </select>
            </section>
        </div>
        <div class="p-4 font-semibold text-xl relative">
            <!-- category -->
            <section>
                <button @click="show = !show" id="dropdownBgHoverButton"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Categories
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>

                <!-- Dropdown menu -->

                    <div @click.away="show = false" x-show="show" class="absolute left-1/2 transform -translate-x-1/2 bg-white border border-gray-200 rounded-lg shadow-lg mt-2 z-50 text-xl sm:text-lg w-50 sm:w-screen sm:max-w-lg">

                        <ul class="py-1 flex justify-start flex-wrap">
                            @foreach($categories as $category)
                                <li class="px-4 py-2 hover:bg-gray-100">
                                    <input type="checkbox" id="{{ $category->id }}" value="{{ $category->id }}" wire:model.live="category">
                                    <label for="{{ $category->id }}">{{ $category->name }}</label>
                                </li>
                            @endforeach
                        </ul>

                    </div>

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

                        <div class="flex justify-center flex-wrap mt-2">
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


