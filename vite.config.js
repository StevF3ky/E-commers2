import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< HEAD
            input: ['resources/css/app.css', 'resources/css/IndexAuth.css' ,'resources/js/app.js', 'resources/css/Home.css'],
=======
            input: ['resources/css/app.css', 'resources/css/IndexAuth.css' ,'resources/js/app.js'],
>>>>>>> 2bacbb1964585033ee4937ec74f057ea86518b58
            refresh: true,
        }),
    ],
});
