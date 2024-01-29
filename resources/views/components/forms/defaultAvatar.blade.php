@props(['avatars'])


{{-- Default Avatar Selection --}}
<div class="flex flex-wrap justify-center">
{{--    <p class="text-center font-bold text-xl">Default Images</p>--}}
    @foreach ($avatars as $avatar)
        <div class="p-2">
            <img src="{{ asset('avatars/' . $avatar) }}"
                 alt="Default Avatar"
                 class="cursor-pointer w-20 h-20" {{-- Adjust size as needed --}}
                 onclick="setDefaultAvatar('{{ $avatar }}')">
        </div>
    @endforeach
</div>

{{-- Hidden input to store selected avatar --}}
<input type="hidden" id="selectedAvatar" name="selected_avatar" value="{{ old('selected_avatar', $user->image ?? '') }}">
