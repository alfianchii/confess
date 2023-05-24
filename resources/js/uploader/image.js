import { imageCrop, imagePreview } from "../filepond";
import { currentPath } from "../helpers/currentPath";

if (currentPath.startsWith("/dashboard/user")) imageCrop();

if (currentPath.startsWith("/dashboard/complaints")) imagePreview();

if (currentPath.startsWith("/dashboard/categories")) imageCrop();

if (currentPath.startsWith("/dashboard/website")) imagePreview();
