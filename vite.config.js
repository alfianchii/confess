import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "css/app.css",
                "js/dashboard.js",
                "js/sweetalert/swalSingle.js",
                "js/sweetalert/swalMulti.js",
                "js/sweetalert.js",
                "js/quill.js",
                "js/image.js",
                "js/navbar.js",
                "js/sluggable/slug.js",
                "js/sluggable.js",
            ].map((path) => `resources/${path}`),
            refresh: true,
        }),
    ],
});
