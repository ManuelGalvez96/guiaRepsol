import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
<<<<<<< HEAD
                'resources/js/login.js',
                'resources/js/registro.js',
                'resources/js/restaurantes.js'
=======
>>>>>>> aba0d2dd31e34dd42bc41567bb71679a80c3019f
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
