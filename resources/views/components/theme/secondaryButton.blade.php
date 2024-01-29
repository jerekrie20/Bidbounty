@props(['route'])

<a class="block px-4 py-3 mb-2 leading-loose text-xs text-center text-white font-bold bg-earth-green hover:bg-blue-700 rounded"
   href="{{$route}}">{{$slot}}</a>
