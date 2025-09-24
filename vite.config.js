import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        // Enable minification
        minify: 'terser',
        
        // Optimize assets
        rollupOptions: {
            output: {
                // Separate vendor chunks for better caching
                manualChunks: {
                    vendor: ['alpinejs'],
                },
                // Add hash to file names for cache busting
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]'
            }
        },
        
        // Compress assets
        terserOptions: {
            compress: {
                drop_console: true, // Remove console logs in production
                drop_debugger: true,
            },
        },
        
        // Set chunk size warning limit
        chunkSizeWarningLimit: 1000,
    },
    
    // Configure development server
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});
