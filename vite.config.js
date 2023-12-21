import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";
import i18n from "laravel-vue-i18n/vite";

export default defineConfig({
    build: {
        target: "esnext",
        chunkSizeWarningLimit: 1600,
    },
    plugins: [
        laravel(["resources/scss/app.scss", "resources/js/app.js"]),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        i18n(),
    ],
    resolve: {
        alias: {
            "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
            "~vue-toastification": path.resolve(
                __dirname,
                "node_modules/vue-toastification"
            ),
            "~vue-multiselect": path.resolve(
                __dirname,
                "node_modules/vue-multiselect"
            ),
            "~sweetalert2": path.resolve(__dirname, "node_modules/sweetalert2"),
            "~boxicons": path.resolve(__dirname, "node_modules/boxicons"),
            "~@mdi": path.resolve(__dirname, "node_modules/@mdi"),
            "~dropzone": path.resolve(__dirname, "node_modules/dropzone"),
            "@": "/resources/js",
            "@r": "resources",
        },
    },
});
