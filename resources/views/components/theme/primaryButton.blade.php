@props(['route'])

<a class="hidden lg:inline-block lg:ml-auto lg:mr-3 py-2 px-6 bg-sky-blue hover:bg-gray-100 text-sm text-gray-900 font-bold  rounded-xl transition duration-200"
   href="{{$route}}">{{ $slot }}</a>
