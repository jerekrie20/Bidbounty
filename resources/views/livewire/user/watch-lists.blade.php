<?php


use function Livewire\Volt\{state, usesPagination,layout,title,with};

usesPagination();

layout('components.layouts.auction');
title('Watch List');

with(fn() => [
    'watchLists' => auth()->user()->watchlists()->with('item.lot')->paginate(10),
]);

// Remove from watch list
$removeFromWatchList = fn($id) => auth()->user()->watchlists()->where('id', $id)->delete();

?>

<div>
    <h1 class="mt-10 mb-4 text-4xl dark:text-emerald-100 font-bold text-gray-700 pb-4 pt-3 text-center">Watch List</h1>

    <div class="w-full p-2 sm:w-2/3 m-auto mt-3 mb-10">
    @foreach($watchLists as $list)

            <div class="max-w-5xl mx-auto mt-8">
                <div class="border-l-2 border-rust-orange pl-8">
                    <div class="flex flex-col md:flex-row md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-2xl text-cloud-white font-bold mb-2">{{ $list->item->lot->title }}</h2>
                            <p class="text-lavender-purple text-sm">
                                {{ \Carbon\Carbon::parse($list->item->lot->start_date)->format('Y-m-d h:i A') }} - {{ \Carbon\Carbon::parse($list->item->lot->end_date)->format('Y-m-d h:i A') }}
                            </p>
                        </div>
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-xl text-cloud-white font-bold mb-2">{{ $list->item->title }}</h3>
                            <p class="text-lavender-purple text-sm">
                                Watched on: {{ \Carbon\Carbon::parse($list->created_at)->format('Y-m-d h:i A') }}
                            </p>
                        </div>

                        <div class="mb-4 md:mb-0">
                            <a href="{{ route('auction.single.item', ['lotId' => $list->item->lot->id, 'itemId' => $list->item->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">View</a>
                            <button class="bg-red-500 text-white px-4 py-2 rounded-lg" wire:click="removeFromWatchList({{ $list->id }})">Remove</button>
                        </div>

                    </div>

                </div>
            </div>

    @endforeach
    </div>
</div>
