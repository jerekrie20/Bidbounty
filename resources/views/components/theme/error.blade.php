@if(Session::has('error'))
    <div x-data="{ show: true }"
         x-init="setTimeout(() => show = false, 3000)"
         x-show="show"
         class="text-lg text-danger-red text-center" id="error">
        {{ Session::get('error') }}
    </div>
@endif
