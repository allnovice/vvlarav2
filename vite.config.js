import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    return {
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
            host: '0.0.0.0',
            hmr: {
                // Now "env" exists, so this will parse your APP_URL perfectly!
                host: env.APP_URL ? env.APP_URL.replace('http://', '').replace('https://', '') : 'localhost'
            },
        },
    };
});

