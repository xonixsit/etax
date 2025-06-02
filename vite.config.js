import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(
    {
    host: '127.0.0.1',
    hmr: {
      host: 'localhost',
    },
    build:{
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: ['resources/js/app.js','resources/css/app.css'],
            
            output:{
                
            }
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
