import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                // 'node_modules/summernote/dist/summernote.min.css',
                // 'node_modules/summernote/dist/summernote.min.js'
            ],
            refresh: true,
        }),
    ],
});
