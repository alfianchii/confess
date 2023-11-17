import { defineConfig, loadEnv } from "vite";
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
export default (mode) => {
    process.env = { ...process.env, ...loadEnv(mode, process.cwd()) };

    return defineConfig({
        // Server
        server: {
            // Serve all host
            host: "0.0.0.0",
            hmr: {
                clientPort: process.env.VITE_APP_PORT,
                host: process.env.VITE_APP_HOST,
                // ws = websocket
                protocol: "ws",
            },
            port: process.env.VITE_APP_PORT,
            watch: {
                usePolling: true,
            },
        },

        // Plugins
        plugins: [laravel({ input: files, refresh: true })],
    });
};
