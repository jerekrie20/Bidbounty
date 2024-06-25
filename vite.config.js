import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'node_modules/lightbox2/dist/css/lightbox.min.css',
                'node_modules/lightbox2/dist/js/lightbox.min.js',
            ],
            refresh: true,
        }),
    ],
});
