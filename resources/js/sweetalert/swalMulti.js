import { handleDelete, handlePromoteDemote } from "../sweetalert";
import { currentPath } from "../helpers/currentPath";

// Multiple delete buttons (add a click event listener to each delete button)
if (currentPath === "/dashboard/complaints") {
    document
        .getElementById("table1")
        .addEventListener("click", function (event) {
            if (
                event.target &&
                event.target.classList.contains("delete-record")
            ) {
                handleDelete(
                    event.target.dataset.slug,
                    "keluhan",
                    "/dashboard/complaints"
                );
            }
        });
} else if (currentPath === "/dashboard/responses") {
    document
        .getElementById("table1")
        .addEventListener("click", function (event) {
            if (
                event.target &&
                event.target.classList.contains("delete-record")
            ) {
                handleDelete(
                    event.target.dataset.slug,
                    "tanggapan",
                    "/dashboard/responses"
                );
            }
        });
} else if (currentPath === "/dashboard/categories") {
    document
        .getElementById("table1")
        .addEventListener("click", function (event) {
            if (
                event.target &&
                event.target.classList.contains("delete-record")
            ) {
                handleDelete(
                    event.target.dataset.slug,
                    "kategori",
                    "/dashboard/categories"
                );
            }
        });
} else if (currentPath.startsWith("/dashboard/responses/create")) {
    document
        .getElementById("responses")
        .addEventListener("click", function (event) {
            if (
                event.target &&
                event.target.classList.contains("delete-record")
            ) {
                handleDelete(
                    event.target.dataset.slug,
                    "tanggapan",
                    "/dashboard/responses",
                    currentPath
                );
            }
        });
} else if (currentPath === "/dashboard/users") {
    document
        .getElementById("table1")
        .addEventListener("click", function (event) {
            if (
                event.target &&
                event.target.classList.contains("delete-record")
            ) {
                handleDelete(
                    event.target.dataset.slug,
                    "pengguna",
                    "/dashboard/users"
                );
            }

            // Promote and demote user
            if (
                event.target &&
                event.target.classList.contains("promote-record")
            ) {
                handlePromoteDemote(
                    "promote",
                    event.target.dataset.user,
                    "/dashboard/user",
                    `/dashboard/users/${event.target.dataset.user}`
                );
            } else if (
                event.target &&
                event.target.classList.contains("demote-record")
            ) {
                handlePromoteDemote(
                    "demote",
                    event.target.dataset.user,
                    "/dashboard/user",
                    `/dashboard/users/${event.target.dataset.user}`
                );
            }
        });
}
