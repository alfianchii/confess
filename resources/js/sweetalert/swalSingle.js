import { handleDelete } from "../sweetalert";

// Path
const currentPath = window.location.pathname;

// Single delete button
const buttons = document.getElementsByClassName("delete-record");
for (const btn of buttons) {
    btn.addEventListener("click", function (e) {
        if (currentPath.startsWith("/dashboard/complaints")) {
            handleDelete(
                e.target.dataset.slug,
                "keluhan",
                "/dashboard/complaints"
            );
        } else if (currentPath.startsWith("/dashboard/responses")) {
            handleDelete(
                e.target.dataset.slug,
                "tanggapan",
                "/dashboard/responses"
            );
        }
    });
}
