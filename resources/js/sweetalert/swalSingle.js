import { handleDelete } from "../sweetalert";

// Single delete button
const buttons = document.getElementsByClassName("delete-record");
for (const btn of buttons) {
    btn.addEventListener("click", function (e) {
        handleDelete(e.target.dataset.slug);
    });
}
