import { handleDelete } from "../sweetalert";

// Path
const currentPath = window.location.pathname;

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
        .getElementById("table2")
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
        .getElementById("table3")
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
}
