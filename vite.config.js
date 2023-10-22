import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import AutoImport from "unplugin-auto-import/vite";

export default defineConfig({
    plugins: [
        AutoImport({
            include: [
                /\.[tj]sx?$/,
                /\.vue$/,
                /\.vue\?vue/,
                /\.md$/,
            ],
            imports: [
                "vue",
                "pinia",
                "vue-router",
                {
                    "@vueuse/core": [

                        "useMouse",

                        ["useFetch", "useMyFetch"],
                    ],
                },
                {
                    from: "vue-router",
                    imports: ["RouteLocationRaw"],
                    type: true,
                },
            ],
            defaultExportByFilename: false,
            dirs: ["./resources/js/stores/**", "./resources/js/composables/**"],
            dts: "./auto-imports.d.ts",
            vueTemplate: false,
            resolvers: [
                /* ... */
            ],
            injectAtEnd: true,
            eslintrc: {
                enabled: false,
                filepath: "./.eslintrc-auto-import.json",
                globalsPropValue: true,
            },
        }),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: "0.0.0.0",
        hmr: {
            host: "localhost",
        },
        watch: {
            usePolling: true,
        },
    },
});
