import {defineConfig} from 'vite';
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin';
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/base.scss', 'resources/js/app.ts'],
            refresh: true,
        }),
        vue(),
    ],
    server: {
        host: 'dnd-sound',  // ваш домен
        port: 5173,         // порт (можно оставить 5173)
        cors: true,
        hmr: {
            host: 'dnd-sound',
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources'),
            '@scss': path.resolve(__dirname, 'resources/scss'),
            '@stores': path.resolve(__dirname, 'resources/vue/stores'),
            '@components': path.resolve(__dirname, 'resources/vue/components'),
        }
    }
});
