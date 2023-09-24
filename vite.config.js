import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import fs from "fs";
import { resolve } from "path";

const root = resolve(__dirname, "resources");

const resourceFiles = (dirPath, filesArray = []) => {
    const files = fs.readdirSync(dirPath);

    for (const file of files) {
        if (file !== "views") {
            const filePath = resolve(dirPath, file);
            const fileStat = fs.statSync(filePath);
            fileStat.isDirectory()
                ? resourceFiles(filePath, filesArray)
                : filesArray.push(filePath);
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
