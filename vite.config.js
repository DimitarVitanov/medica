import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
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
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    // Split Vue core separately
                    if (id.includes('node_modules/vue')) {
                        return 'vue';
                    }
                    // Split Inertia separately
                    if (id.includes('@inertiajs')) {
                        return 'inertia';
                    }
                    // Split Swiper (lazy loaded anyway)
                    if (id.includes('swiper')) {
                        return 'swiper';
                    }
                    // Other vendor modules
                    if (id.includes('node_modules')) {
                        return 'vendor';
                    }
                },
            },
        },
        cssCodeSplit: true,
        minify: 'esbuild',
        target: 'es2020',
    },
});
