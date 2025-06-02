import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(
    {
        server: {
            host: '0.0.0.0',
            IP : '74.208.47.107',
            https: true,
            hmr: {
                host: 'etax.xonixs.com',
            },
            headers: {
                'Access-Control-Allow-Origin': '*',
            },
        },
        base: process.env.ASSET_URL || '/',     
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
            tailwindcss(),
        ],
});
