import { imageCrop, imagePreview } from "../filepond";
import { currentPath } from "../helpers/currentPath";

if (currentPath.startsWith("/dashboard/user")) {
    imageCrop();
}

if (currentPath.startsWith("/dashboard/complaints")) {
    imagePreview();
}
