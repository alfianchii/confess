import { handleClick } from "../../sweetalert";

// ---------------------------------
// Guide
document.documentElement.addEventListener("click", function (event) {
    const unique = event.target.dataset.unique ?? "";

    // Destroy
    if (event.target && event.target.matches("[data-confirm-guide-destroy]"))
        handleClick({
            data: { unique },
            event: {
                noun: "panduan",
                verb: "menghapus",
                method: "DELETE",
            },
            uri: {
                url: `/dashboard/setting/guides`,
            },
            redirect: "/dashboard/setting/guides",
        });
});
