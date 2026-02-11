import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/restaurantes.js',
                'resources/js/restaurante-detalle.js',
                'resources/js/admin_js/admin_index.js',
                'resources/js/admin_js/admin_create.js',
                'resources/js/admin_js/admin_edit.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
