<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <title>{{ $title ?? 'BidBounty' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <script src="https://kit.fontawesome.com/9a1bef43f6.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto:wght@400;500;700&display=swap"
          rel="stylesheet">

    <script>
        function setDefaultAvatar(avatarFilename) {
            // Set the value of a hidden input field to the selected avatar filename
            document.getElementById('selectedAvatar').value = avatarFilename;

            // Clear the file input if a default avatar is selected
            document.getElementById('dropzone-file').value = '';
            document.getElementById('file-instruction').textContent = avatarFilename;
            document.getElementById('file-name').textContent = '';

            // Update the displayed avatar
            document.getElementById('currentAvatar').src = "{{ asset('avatars') }}/" + avatarFilename;
        }

        function clearDefaultAvatarSelection() {
            // Clear the selected avatar when a file is uploaded
            document.getElementById('selectedAvatar').value = '';
        }

    </script>

</head>
<body class="antialiased flex flex-col min-h-screen">

<div class="bg-midnight-blue">

    <nav class="relative px-4 py-4 flex justify-between items-center bg-midnight-blue border-b-2 border-gray-100">
        <a class="text-3xl font-bold leading-none" href="/">
            <x-theme.logo/>
        </a>
        <div class="lg:hidden">
            <button class="navbar-burger flex items-center text-rust-orange p-3">
                <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Mobile menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                </svg>
            </button>
        </div>
        <x-menus.nav>
            <x-menus.nav-items name="Auctions" href="/auction"></x-menus.nav-items>
            <x-icons.dots-vertical></x-icons.dots-vertical>
            <x-menus.nav-items name="Bids" href="/bids"></x-menus.nav-items>
            <x-icons.dots-vertical></x-icons.dots-vertical>
            <x-menus.nav-items name="Wishlist" href="/wishlist"></x-menus.nav-items>
            <x-icons.dots-vertical></x-icons.dots-vertical>
            <x-menus.nav-items name="Messages" href="/message"></x-menus.nav-items>
            <x-icons.dots-vertical></x-icons.dots-vertical>
            <x-menus.nav-items name="Payments" href="/payments"></x-menus.nav-items>
        </x-menus.nav>

        @auth()
            <a class="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-sky-blue hover:bg-gray-100 text-sm text-gray-900 font-bold  rounded-xl transition duration-200"
               href="/dashboard">Dashboard</a>

            <form action="/logout" method="post">
                @csrf
                <button
                    class="hidden lg:inline-block py-2 px-6 bg-green-600 hover:bg-white hover:text-gray-900 text-sm text-white font-bold rounded-xl transition duration-200"
                    type="submit">Logout
                </button>
            </form>
        @endauth
        @guest()
            <a class="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-sky-blue hover:bg-gray-100 text-sm text-gray-900 font-bold  rounded-xl transition duration-200"
               href="/login">Sign In</a>
            <a class="hidden lg:inline-block py-2 px-6 bg-green-600 hover:bg-earth-green text-sm text-white font-bold rounded-xl transition duration-200"
               href="/register">Sign up</a>
        @endguest
    </nav>
    <div class="navbar-menu relative z-50 hidden">
        <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
        <nav
            class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-midnight-blue border-r overflow-y-auto">
            <div class="flex items-center mb-8">
                <a class="mr-auto text-3xl font-bold leading-none" href="#">
                    <x-theme.logo/>
                </a>
                <button class="navbar-close">
                    <svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div>
                <ul>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-semibold text-cloud-white rounded"
                           href="#">Home</a>
                    </li>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-semibold text-cloud-white rounded"
                           href="#">About Us</a>
                    </li>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-semibold text-cloud-white rounded"
                           href="#">Services</a>
                    </li>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-semibold text-cloud-white rounded"
                           href="#">Pricing</a>
                    </li>
                    <li class="mb-1">
                        <a class="block p-4 text-sm font-semibold text-cloud-white rounded"
                           href="#">Account</a>
                    </li>
                </ul>
            </div>
            <div class="mt-auto">
                <div class="pt-6">

                    @auth()
                        <div class="flex justify-center ">
                            <a class="lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-sky-blue hover:bg-gray-100 text-sm text-gray-900 font-bold  rounded-xl transition duration-200 mr-2"
                               href="/dashboard">Dashboard</a>

                            <form action="/logout" method="post">
                                @csrf
                                <button
                                    class="lg:inline-block py-2 px-6 bg-green-600 hover:bg-white hover:text-gray-900 text-sm text-white font-bold rounded-xl transition duration-200"
                                    type="submit">Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                    @guest()
                        <x-theme.primaryButton route="/login">Sign In</x-theme.primaryButton>
                        <x-theme.secondaryButton route="/register">Sign Up</x-theme.secondaryButton>
                    @endguest


                </div>
                <p class="my-4 text-xs text-center text-gray-400">
                    <span>Copyright &copy; {{date("Y")}}</span>
                </p>
            </div>
        </nav>
    </div>

</div>

<!-- Page Content -->
<main class="dark:bg-gray-800 bg-white flex-grow" >
    {{ $slot }}
</main>

<!-- component -->
<!-- This is an example component -->
<div class="bg-midnight-blue text-white p-4 text-center">
    <div class="max-w-2xl mx-auto text-white py-10">
        <div class="text-center">
            <h3 class="text-3xl mb-3"> Download Our App </h3>
            <p></p>
            <div class="flex justify-center my-10">
                <div class="flex items-center border w-auto rounded-lg px-4 py-2 w-52 mx-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/888/888857.png" class="w-7 md:w-8">
                    <div class="text-left ml-3">
                        <p class='text-xs text-gray-200'>Download on </p>
                        <p class="text-sm md:text-base"> Google Play Store </p>
                    </div>
                </div>
                <div class="flex items-center border w-auto rounded-lg px-4 py-2 w-44 mx-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/888/888841.png" class="w-7 md:w-8">
                    <div class="text-left ml-3">
                        <p class='text-xs text-gray-200'>Download on </p>
                        <p class="text-sm md:text-base"> Apple Store </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-28 flex flex-col md:flex-row md:justify-between items-center text-sm text-gray-400">
            <p class="order-2 md:order-1 mt-8 md:mt-0"> &copy; BidBounty, {{date("Y")}}. </p>
            <div class="order-1 md:order-2">
                <span class="px-2">About us</span>
                <span class="px-2 border-l">Contact us</span>
                <span class="px-2 border-l">Privacy Policy</span>
            </div>
        </div>
    </div>
</div>

<script>
    // Burger menus
    document.addEventListener('DOMContentLoaded', function () {
        // open
        const burger = document.querySelectorAll('.navbar-burger');
        const menu = document.querySelectorAll('.navbar-menu');

        if (burger.length && menu.length) {
            for (var i = 0; i < burger.length; i++) {
                burger[i].addEventListener('click', function () {
                    for (var j = 0; j < menu.length; j++) {
                        menu[j].classList.toggle('hidden');
                    }
                });
            }
        }

        // close
        const close = document.querySelectorAll('.navbar-close');
        const backdrop = document.querySelectorAll('.navbar-backdrop');

        if (close.length) {
            for (var i = 0; i < close.length; i++) {
                close[i].addEventListener('click', function () {
                    for (var j = 0; j < menu.length; j++) {
                        menu[j].classList.toggle('hidden');
                    }
                });
            }
        }

        if (backdrop.length) {
            for (var i = 0; i < backdrop.length; i++) {
                backdrop[i].addEventListener('click', function () {
                    for (var j = 0; j < menu.length; j++) {
                        menu[j].classList.toggle('hidden');
                    }
                });
            }
        }


        // document.getElementById('dropzone-file').addEventListener('change', function (event) {
        //     var fileName = event.target.files[0].name;
        //     document.getElementById('file-instruction').textContent = "Selected file: ";
        //     document.getElementById('file-name').textContent = fileName;
        // });

    });


</script>
</body>
</html>


