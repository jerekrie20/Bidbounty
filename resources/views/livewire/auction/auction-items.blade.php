@php use function Livewire\Volt\js; @endphp
<div>
    <h1 class="mt-10 mb-4 text-4xl dark:text-emerald-100 font-bold text-gray-700 pb-4 pt-3 text-center">Auction
        Items</h1>

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
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-lavender-purple mx-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Auction Items</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

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
            <label for="start_date" class="text-white">Start Time:</label>
            <input type="time" name="start_time" wire:model.live.debounce.500ms="start_time"
                   class="text-rust-orange caret-rust-orange">
        </div>
        <div class="p-4 font-semibold text-xl">
            <!-- date -->
            <label for="end_date" class="text-white">End Time:</label>
            <input type="time" name="end_time" wire:model.live.debounce.500ms="end_time" class="text-rust-orange caret-rust-orange">
        </div>
    </div>

    <div class="flex justify-center items-center xl:w-2/3 m-auto">
        <div class="p-4 font-semibold text-xl">
            <section>
                <select name="status" id="status" wire:model.live="status"
                        class="bg-sky-blue text-black text-lg border-2 w-full p-2 rounded-lg">
                    <option value="">Select Status</option>
                    <option value="available">Available</option>
                    <option value="pending">Pending</option>
                    <option value="sold">Sold</option>
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

    <div class="mt-10">
        {{ $auctionItems->onEachSide(5)->links() }}
    </div>

    <div class="flex flex-col items-center flex-wrap  m-auto md:flex-row lg:w-3/4">

        @if($auctionItems->isEmpty())
            <div class="w-full p-4 text-center">
                <h1 class="text-2xl font-bold text-white">No Items Found</h1>
            </div>
        @endif
        @foreach($auctionItems as $item)
            <a href="/auction/item/{{ $item->id }}">

                <div class="w-full md:w-1/2 lg:w-1/3 p-4 hover:cursor-pointer md:h-[41rem]">
                    <div class="bg-white rounded-lg overflow-hidden h-full shadow-lg hover:shadow-wheat-yellow">
                        <div class="relative">
                            @php
                                $image = json_decode($item->images);
                            @endphp

                            <img class="w-full h-auto object-cover object-center"
                                 src="{{ asset($image[0][0]  ? 'items/' . $image[0][0] : 'items/default.webp') }}"
                                 alt="{{ $item->title }} Image">
                            <div class="absolute top-0 right-0 p-2 font-bold {{$this->bgColor($item->status)}}">
                                {{$item->status}}
                            </div>
                        </div>
                        <div class="flex justify-between bg-rust-orange font-semibold">
                            <p class="p-2 text-white">
                                Start: {{ \Carbon\Carbon::parse($item->start_time)->format('h:i A') }}</p>
                            <p class="p-2 text-white">
                                End: {{ \Carbon\Carbon::parse($item->end_time)->format('h:i A') }}</p>
                        </div>

                        <div class="flex justify-center mt-2">
                            @foreach($item->categories as $category)
                                <p class="p-1">{{ $category->name }}</p><i
                                    class="p-2 fa-solid fa-ellipsis-vertical fa-beat text-midnight-blue"></i>
                            @endforeach
                        </div>

                        <div class='p-4 text-center'>
                            <h2 class='text-2xl font-bold text-gray-800'>{{ $item->title }}</h2>
                            <p class='mt-2 text-gray-600'>{{ $item->description }}</p>
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

    <div class="flex justify-center mt-4 mb-10">
        {{ $auctionItems->links() }}
    </div>

</div>
