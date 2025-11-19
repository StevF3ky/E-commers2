import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/IndexAuth.css' ,'resources/js/app.js', 'resources/css/Home.css', 'resources/css/seller.css', 'resources/js/seller.js',
            'public/js/product-detail.js', 'public/css/product-detail.css'
            ],
            refresh: true,
        }),
    ],
});
