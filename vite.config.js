import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import fs from "fs";
import path, { resolve } from "path";
import { fileURLToPath } from "url";

// Root path
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const root = resolve(__dirname, "resources");

// Load all of files on "views" folder
const resourceFiles = (dirPath, filesArray = []) => {
    const paths = fs.readdirSync(dirPath);

    for (const path of paths) {
        if (path !== "views") {
            const basePath = resolve(dirPath, path);
            const pathStat = fs.statSync(basePath);
            pathStat.isDirectory()
                ? resourceFiles(basePath, filesArray)
                : filesArray.push(basePath);
        }
    }

    return filesArray;
};
const files = resourceFiles(root);

// Configs
export default defineConfig({
    plugins: [laravel({ input: files })],
    server: {
        host: "0.0.0.0",
        hmr: {
            clientPort: 3000,
            host: "127.0.0.1",
        },
        port: 3000,
        open: false,
        watch: {
            usePolling: true,
        },
    },
});
