@props(['title','action'])

<h1 class="mt-10 mb-4 text-4xl dark:text-emerald-100 font-bold text-gray-700 pb-4 pt-3 text-center border-l-2 border-white">{{ $title }}</h1>

<div class="overflow-hidden shadow-sm sm:rounded-lg 2xl:w-2/3 lg:w-10/12 m-auto">
    <div class="p-6 bg-white border-b border-gray-200 mb-10">
        <!-- Here we specify the Livewire event to call on form submission -->
        <form wire:submit.prevent="{{$action}}" enctype="multipart/form-data">
            {{-- CSRF is not needed with Livewire as it handles it automatically --}}

            {{ $slot }} <!-- This is where the rest of your form inputs will be inserted -->

        </form>
    </div>
</div>
