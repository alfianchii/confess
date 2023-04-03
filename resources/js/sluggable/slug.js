import { sluggable } from "../sluggable";
import { currentPath } from "../helpers/currentPath";

// Sluggable
if (currentPath.startsWith("/dashboard/complaints")) {
    let title = document.querySelector("#title");

    sluggable(title, "title", "/dashboard/complaints");
} else if (currentPath.startsWith("/dashboard/categories")) {
    let name = document.querySelector("#name");

    sluggable(name, "name", "/dashboard/categories");
}
