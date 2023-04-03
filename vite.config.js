import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import fs from "fs";

export default defineConfig({
    plugins: [
        laravel({
            input: fs
                .readdirSync("resources")
                .filter((file) => fs.statSync(`resources/${file}`).isFile()),
            refresh: true,
        }),
    ],
});
