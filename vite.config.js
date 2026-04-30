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
                    // Tiptap/ProseMirror — admin-only, ~200KB (never loaded on public pages)
                    if (id.includes('tiptap') || id.includes('prosemirror')) {
                        return 'tiptap';
                    }
                    // Split Swiper (lazy loaded anyway)
                    if (id.includes('swiper')) {
                        return 'swiper';
                    }
                    // Lenis smooth scroll — deferred, loaded async
                    if (id.includes('lenis')) {
                        return 'lenis';
                    }
                    // Ziggy routes
                    if (id.includes('ziggy')) {
                        return 'ziggy';
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
