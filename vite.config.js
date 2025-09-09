import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/react/app.css', 'resources/js/react/app.jsx'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
