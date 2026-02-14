import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
<<<<<<< HEAD
                'resources/css/app.css', 
                'resources/js/app.js',
=======
                'resources/js/admin_js/admin_index.js',
                'resources/js/admin_js/admin_edit.js',
                'resources/js/admin_js/admin_create.js',
>>>>>>> 69f9145fe8b752297542c833ce18a7ac36f1689f
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
