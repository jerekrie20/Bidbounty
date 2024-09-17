<?php

use App\Models\Bid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Livewire\Volt\{state, usesPagination, layout, title, with};

usesPagination();

layout('components.layouts.auction');
title('Bids');


//Get the user bids where the user is the highest bidder and the auction is closed/pending
with(fn() => [
    'bids' => Bid::select('bids.*')
        ->joinSub( // Subquery to get the highest bid for each item
            Bid::select('item_id', DB::raw('MAX(amount) as max_amount')) // Select the highest bid amount
            ->groupBy('item_id'), // Group by item_id
            'max_bids',
            function ($join) { // Join the subquery
                $join->on('bids.item_id', '=', 'max_bids.item_id') // Join on item_id
                ->on('bids.amount', '=', 'max_bids.max_amount'); // Join on amount
            }
        )
        ->where('bids.user_id', Auth::id()) // Where the user is the highest bidder
        ->whereHas('item', function ($query) { // Where the item is pending
            $query->where('status', 'pending');
        })
        ->with('item.lot') // Eager load the item and lot
        ->get(),
]);

?>

<div>
    <h1 class="mt-10 mb-4 text-4xl dark:text-emerald-100 font-bold text-gray-700 pb-4 pt-3 text-center">Bids</h1>

    <div class="sm:w-3/4 mx-auto overflow-x-auto">
        <div class="min-w-max">
            <table class="table">
                <!-- head -->
                <thead>
                <tr class="text-peach-pink text-lg">
                    <th class="text-cloud-white">Name</th>
                    <th class="text-cloud-white">Owner</th>
                    <th class="text-cloud-white">Price</th>
                    <th class="text-cloud-white">Status</th>
                    <th class="text-cloud-white">Auctions</th>
                </tr>
                </thead>
                <tbody>
                <!-- row 1 -->
                @foreach($bids as $bid)
                    <tr class="text-peach-pink">
                        <td class="text-cloud-white font-semibold">
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    @php
                                        $images = json_decode($bid->item->images);
                                        if (is_array($images) && count($images) > 0 && is_array($images[0])) {
                                            $images = array_merge(...$images);
                                        }
                                    @endphp
                                    <div class="mask mask-squircle h-12 w-12">
                                        <img
                                            src="{{ asset($images[0]  ? 'items/' . $images[0] : 'items/default.webp') }}"
                                            alt="Avatar Tailwind CSS Component"/>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-semibold">{{ $bid->item->title }}</div>
                                    <div class="text-sm opacity-50 text-lavender-purple">{{ $bid->item->lot->title }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-cloud-white font-semibold">
                            {{ $bid->item->user->name }}
{{--                            <span class="badge badge-ghost badge-sm">Desktop Support Technician</span>--}}
                        </td>
                        <td class="text-cloud-white font-semibold">${{$bid->amount}}</td>
                        <td class="text-cloud-white font-semibold">{{$bid->item->status}}</td>
                        <th class="text-cloud-white">
                            <a href="{{ route('auction.single.item', ['lotId' => $bid->item->lot->id, 'itemId' => $bid->item->id]) }}">
                                <button class="btn btn-xs sm:btn-sm md:btn-md border-rust-orange mr-1 mb-3 sm:mb-0">View</button>
                            </a>
                            <a href="{{route('transactions',['itemId' => $bid->item->id]) }}">
                            <button class="btn btn-xs sm:btn-sm md:btn-md border-lavender-purple mb-3 sm:mb-0">View Transaction</button>
                            </a>
                            <button class="btn btn-xs sm:btn-sm md:btn-md border-green-700 mb-3 sm:mb-0">Send Message</button>
                        </th>
                    </tr>
                @endforeach

                </tbody>
                <!-- foot -->
                <tfoot>
                <tr class="text-cloud-white">
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Auctions</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>


</div>
