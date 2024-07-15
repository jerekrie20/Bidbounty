import axios from 'axios';
import Pusher from "pusher-js";
import Echo from "laravel-echo";
import $ from 'jquery';

// Define jQuery globally
window.jQuery = $;
window.$ = $;

// Import lightbox after jQuery is defined
import 'lightbox2/dist/js/lightbox.min.js';


window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});


