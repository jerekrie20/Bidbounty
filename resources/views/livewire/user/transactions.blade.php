<?php

use App\Models\Item;
use App\Models\Transaction;
use function Livewire\Volt\{state, usesPagination, layout, title, mount, on};

usesPagination();

layout('components.layouts.auction');
title('Transactions');

state(['transactions']);
state(['singleTransaction']);
state(['success' => null]);
state(['itemId']);
//Get transaction using item id

mount(function ($itemId) {
    $this->itemId = $itemId;
    if (request()->has('success')) {
        $this->success = request()->get('success') === 'true';
    }

    if (!$itemId) {
        $this->transactions = auth()->user()->purchases()
            ->with('item.lot')
            ->get();
        return;
    }
    $this->transactions = auth()->user()->purchases()
        ->where('item_id', $itemId)
        ->with('item.lot')
        ->get();
});


// Process the payment for a selected transaction
$pay = function (Transaction $transaction) {
    $item = $transaction->item;

    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $item->title,
                ],
                'unit_amount' => $transaction->amount * 100,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('transactions', ['itemId' => $this->itemId, 'success' => 'true']),
        'cancel_url' => route('transactions', ['itemId' => $this->itemId, 'success' => 'false']),
    ]);

    return redirect()->away($session->url);
};

?>

<div>
    <h1 class="mt-10 mb-4 text-4xl dark:text-emerald-100 font-bold text-gray-700 pb-4 pt-3 text-center">
        Transactions</h1>

    @if (!is_null($this->success))
        @if ($this->success)
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4 w-1/2 m-auto text-2xl text-center">
                Payment successful!
            </div>
        @else
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                Payment failed or canceled!
            </div>
        @endif
    @endif

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
                @foreach($this->transactions as $transaction)
                    <tr class="text-peach-pink">
                        <td class="text-cloud-white font-semibold">
                            <div class="flex items-center gap-3">
                                <div class="avatar">
                                    @php
                                        $images = json_decode($transaction->item->images);
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
                                    <div class="font-semibold">{{ $transaction->item->title }}</div>
                                    <div
                                        class="text-sm opacity-50 text-lavender-purple">{{ $transaction->item->lot->title }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-cloud-white font-semibold">
                            {{ $transaction->item->user->name }}
                            {{--                            <span class="badge badge-ghost badge-sm">Desktop Support Technician</span>--}}
                        </td>
                        <td class="text-cloud-white font-semibold">${{$transaction->amount}}</td>
                        <td class="text-cloud-white font-semibold">{{$transaction->status}}</td>
                        <th class="text-cloud-white">
                            <a href="{{ route('auction.single.item', ['lotId' => $transaction->item->lot->id, 'itemId' => $transaction->item->id]) }}">
                                <button class="btn btn-xs sm:btn-sm md:btn-md border-rust-orange mr-1 mb-3 sm:mb-0">
                                    View
                                </button>
                            </a>

                            <button wire:click="pay({{$transaction}})"
                                    class="btn btn-xs sm:btn-sm md:btn-md border-lavender-purple mb-3 sm:mb-0">Pay
                            </button>

                            <button class="btn btn-xs sm:btn-sm md:btn-md border-green-700 mb-3 sm:mb-0">Send Message
                            </button>
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
