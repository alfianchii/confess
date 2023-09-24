import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import fs from "fs";
import { resolve } from "path";

const root = resolve(__dirname, "resources");

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

export default defineConfig({
    plugins: [
        laravel({
            input: files,
            refresh: true,
        }),
    ],
});
