import { handleDelete } from "../sweetalert";
import { currentPath } from "../helpers/currentPath";

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
        } else if (currentPath.startsWith("/dashboard/users")) {
            handleDelete(e.target.dataset.slug, "pengguna", "/dashboard/users");
        } else if (currentPath.startsWith("/dashboard/categories")) {
            handleDelete(
                e.target.dataset.slug,
                "kategori",
                "/dashboard/categories"
            );
        }
    });
}
