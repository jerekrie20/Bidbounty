@if(Session::has('success'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 3000)"
         x-show="show"
         class="text-lg text-green-500 text-center" id="success">
        {{ Session::get('success') }}
    </div>
@endif
