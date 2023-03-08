import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/sweetalert/swalSingle.js",
                "resources/js/sweetalert/swalMulti.js",
                "resources/js/sweetalert.js",
                "resources/js/quill.js",
                "resources/js/image.js",
                "resources/js/navbar.js",
            ],
            refresh: true,
        }),
    ],
});
