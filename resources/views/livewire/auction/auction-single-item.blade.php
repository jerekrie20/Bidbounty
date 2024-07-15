<div>
    <div class="w-full sm:w-1/2 m-auto flex flex-wrap justify-center sm:justify-around mt-2">
        <p class="bg-peach-pink p-3 font-semibold rounded-lg mb-2 mr-2 sm:m-0">Lot: {{$lot['title']}}</p>
        <p class="bg-blue-500 p-3 font-semibold rounded-lg mb-2 mr-2 sm:m-0">Status: {{$lot['status']}}</p>
        <p class="bg-green-500 p-3 font-semibold rounded-lg mb-2 mr-2 sm:m-0">Start
            Date: {{ \Carbon\Carbon::parse($lot['start_date'])->format('Y-m-d') }}</p>
        <p class="bg-red-200 p-3 font-semibold rounded-lg mb-2 mr-2 sm:m-0">End
            Date: {{ \Carbon\Carbon::parse($lot['end_date'])->format('Y-m-d') }}</p>
        <button wire:click="$set('showModal', true)"
                class="py-2 px-6 bg-rust-orange rounded-xl text-cloud-white font-semibold hover:text-black hover:bg-lavender-purple mt-3">
            More Info
        </button>
    </div>

    @if($showModal)
        <div wire:transition.out.opacity.duration.200ms
             class="fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-black bg-opacity-50 p-10 z-10">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-xl font-semibold mb-4">Lot: {{$lot['title']}}</h2>
                <hr>
                <div class="flex justify-between mt-4">
                    <p class="font-semibold">Status:</p>
                    <p class="font-semibold">{{$lot['status']}}</p>
                </div>
                <hr>
                <div class="flex justify-between mt-4">
                    <p class="font-semibold">Start Date:</p>
                    <p class="font-semibold">{{ \Carbon\Carbon::parse($lot['start_date'])->format('Y-m-d') }}</p>
                </div>
                <hr>
                <div class="flex justify-between mt-4">
                    <p class="font-semibold">End Date:</p>
                    <p class="font-semibold">{{ \Carbon\Carbon::parse($lot['end_date'])->format('Y-m-d') }}</p>
                </div>
                <hr>
                <div class="mt-4">
                    <p class="font-semibold mb-2">Description: </p>
                    <p class="font-semibold">{{$lot['description']}}</p>
                </div>


                <div class="flex justify-end mt-4">
                    <button wire:click.stop="$set('showModal', false)"
                            class="px-4 py-2 rounded mr-2 text-white bg-blue-500 hover:bg-blue-600">Exit
                    </button>
                </div>
            </div>
        </div>
    @endif

    <h1 class="mt-10 mb-4 text-4xl dark:text-emerald-100 font-bold text-gray-700 pb-4 pt-3 text-center">{{$item->title}}</h1>

    <!-- Breadcrumbs -->

    <div class="flex justify-center items-center xl:w-2/3 m-auto mb-5">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-lavender-purple mx-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('auction.list') }}"
                           class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Auctions</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-lavender-purple mx-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4"/>
                        </svg>
                        <a href="{{ route('auction.item', ['id'=>$lot->id]) }}"
                           class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Auction
                            Items</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-lavender-purple mx-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4"/>
                        </svg>
                        <span
                            class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{$item->title}}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>


    <div class="m-auto w-full sm:w-2/3 mt-4 mb-11">
        <div class="bg-cloud-white flex flex-col-reverse sm:flex-row justify-center">
            <div class="w-full sm:w-1/2 flex flex-wrap">
                @php
                    $images = json_decode($item->images);
                    if (is_array($images) && count($images) > 0 && is_array($images[0])) {
                        $images = array_merge(...$images);
                    }
                @endphp
                @foreach($images as $image)
                    <a href="{{ asset('items/' . $image) }}" data-lightbox="gallery"
                       class="w-1/3 h-auto object-cover rounded-md p-1 mb-2">
                        <img src="{{ asset('items/' . $image) }}" alt="Image Preview">
                    </a>

                @endforeach
            </div>

            <div class="w-full sm:w-1/2">
                <div class="flex justify-between bg-rust-orange font-semibold">
                    <p class="p-2 text-white">
                        Start: {{ \Carbon\Carbon::parse($item->start_time)->inUserTimezone()->format('h:i A') }}</p>
                    <p class="p-2 text-white">
                        End: {{ \Carbon\Carbon::parse($item->end_time)->inUserTimezone()->format('h:i A') }}</p>
                </div>

                <div class="flex justify-between mt-2">
                    <div class="flex justify-center">
                        @foreach($item->categories as $category)
                            <p class="p-1">{{ $category->name }}</p><i
                                class="p-2 fa-solid fa-ellipsis-vertical fa-beat text-midnight-blue"></i>
                        @endforeach
                    </div>
                    <div class="p-2 font-bold {{$this->bgColor($item->status)}}">
                        {{$item->status}}
                    </div>
                </div>

                <div class='p-4 text-center'>
                    <h2 class='text-2xl font-bold text-gray-800'>{{ $item->title }}</h2>
                    <p class='mt-2 text-gray-600'>{{ $item->description }}</p>
                </div>

                <div class="flex justify-center">
                    <p class="p-2 text-lg text-black font-bold">Starting Bid: ${{$item->starting_bid}}</p>
                    <p class="p-2 text-lg text-black font-bold">Current Bid: ${{$item->current_bid}}</p>
                    <p class="p-2 text-lg text-black font-bold">Buy Now Price: ${{$item->reserve_price}}</p>
                </div>

                <hr>

                @auth()
                    @php
                        $start_time = \Carbon\Carbon::parse($item->start_time)->inUserTimezone();
                        $end_time = \Carbon\Carbon::parse($item->end_time)->inUserTimezone();
                        $now = now()->inUserTimezone();
                        $isBidClose = $now < $start_time || $now > $end_time;
                        $isLotLive = $lot->status != 'live';

                        $buttonStyles = "py-2 px-6 rounded-xl text-cloud-white font-semibold hover:text-black";
                        $mainButtonStyle = "$buttonStyles bg-rust-orange hover:bg-lavender-purple mr-3";
                        $wishlistButtonStyle = "$buttonStyles bg-midnight-blue hover:bg-peach-pink";
                    @endphp

                    <div class="flex justify-center mb-4 mt-4">
                        @if($isLotLive)
                            <p class="p-3 font-bold text-danger-red text-lg">Lot {{ $lot->status }}</p>
                        @elseif($isBidClose)
                            <p class="p-3 font-bold text-danger-red text-lg">Item Not live/Closed</p>
                        @else
                            <button wire:click="showBid"
                                    class="{{ $mainButtonStyle }}">
                                Bid Now!
                            </button>
                        @endif

                        <button wire:click="wishlist"
                                class="{{ $wishlistButtonStyle }}">
                            Wishlist
                        </button>
                    </div>
                @endauth
                @guest()
                    <div class="flex justify-center mb-4 mt-4">
                        <a href="{{ route('login') }}"
                           class="py-2 px-6 bg-rust-orange rounded-xl text-cloud-white font-semibold hover:text-black hover:bg-lavender-purple mr-3">Login
                            to Bid</a>
                    </div>
                @endguest

            </div>

        </div>

        @if($showBidModal)
            <div wire:transition.out.opacity.duration.200ms class="p-10 ">
                <div class="bg-cloud-white w-full rounded-lg shadow-lg p-8">
                    <h2 class="text-xl font-semibold mb-4">Bid Now</h2>
                    <hr>
                    <x-theme.success/>
                    <x-theme.error/>
                    <hr>
                    <div class="flex justify-around mb-3">
                        <div>
                            <div class="flex justify-start ">
                                <p class="font-semibold mb-2 mr-2">Current Bid: </p>
                                <p class="font-semibold">${{ $item->current_bid }}</p>
                            </div>
                            <div class="flex justify-start mt-4">
                                <div class="mr-3">
                                    <p>${{ $item->current_bid }} <span>+</span> <span>$100</span></p>
                                </div>
                                <div class="">
                                    <p class="font-semibold mb-2">Next Bid: ${{ $item->current_bid + 100 }} </p>
                                </div>
                            </div>

                            <div>
                                <button wire:click="bid"
                                        class="py-2 px-6 bg-rust-orange rounded-xl text-cloud-white font-semibold hover:text-black hover:bg-lavender-purple mr-3">
                                    Bid Now
                                </button>
                            </div>

                        </div>

                        <div>
                            <div class="flex justify-start">
                                <div class="mr-3">
                                    <p class="font-semibold mb-2">Buy Now Price: </p>
                                    <p class="font-semibold">${{ $item->reserve_price }}</p>
                                </div>
                            </div>

                            <div>
                                <button wire:click="bid"
                                        class="py-2 px-6 bg-rust-orange rounded-xl text-cloud-white font-semibold hover:text-black hover:bg-lavender-purple mr-3">
                                    Buy Now
                                </button>
                            </div>

                        </div>

                        <div>
                            <div class="flex justify-start ">
                                <p class="font-semibold mb-2 mr-2">Custom Bid: </p>
                            </div>
                            <div class="mb-2">
                                <input type="number" wire:model="bidAmount"
                                       class="w-24 h-10 border border-gray-300 rounded-md p-2">
                            </div>
                            <div>
                                <button wire:click="customBid"
                                        class="py-2 px-6 bg-rust-orange rounded-xl text-cloud-white font-semibold hover:text-black hover:bg-lavender-purple mr-3">
                                    Custom Bid
                                </button>
                            </div>


                        </div>

                    </div>

                    <hr>

                    <h2 class="text-xl font-semibold mb-4 mt-5">Live Bid</h2>

                    <div>
                        @foreach($bids as $bid)
                            <div class="flex justify-between">
                                <p class="font-semibold">Bidder: {{ $bid->user->name }}</p>
                                <p class="font-semibold">
                                    Time: {{ \Carbon\Carbon::parse($item->created_at)->format('h:i A') }}</p>
                                <p class="font-semibold">Bid: ${{ $bid->amount }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end mt-4">
                        <button wire:click.stop="$set('showBidModal', false)"
                                class="px-4 py-2 rounded mr-2 text-white bg-blue-500 hover:bg-blue-600">Exit
                        </button>
                    </div>

                </div>
            </div>
        @endif


    </div>

    @livewireScripts(['echo' => ['broadcaster' => 'pusher', 'key' => env('PUSHER_APP_KEY'), 'cluster' => env('PUSHER_APP_CLUSTER'), 'encrypted' => true]])

</div>
