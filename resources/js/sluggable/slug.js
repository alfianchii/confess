import { sluggable } from "../sluggable";

// Current path
const currentPath = window.location.pathname;

// Sluggable
if (currentPath.startsWith("/dashboard/complaints")) {
    let title = document.querySelector("#title");

    sluggable(title, "title", "/dashboard/complaints");
} else if (currentPath.startsWith("/dashboard/categories")) {
    let name = document.querySelector("#name");

    sluggable(name, "name", "/dashboard/categories");
}
