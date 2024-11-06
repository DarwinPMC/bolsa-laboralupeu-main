import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/custom.css', // Añade tu archivo custom.css
                'resources/js/app.js',
                'resources/js/ofertas.js',
                'resources/js/postulaciones.js',


            ],
            refresh: true,
        }),
    ],
});
