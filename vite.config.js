import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(
    {
    base: process.env.ASSET_URL || '/',
    server: {
        headers: {
            'Access-Control-Allow-Origin': '*',
        },
    },    
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
