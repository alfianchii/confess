import { handleDelete } from "../sweetalert";

// Multiple delete buttons (add a click event listener to each delete button)
document
    .getElementsByTagName("table")[0]
    .addEventListener("click", function (event) {
        if (event.target && event.target.classList.contains("delete-record")) {
            handleDelete(event.target.dataset.slug);
        }
    });
