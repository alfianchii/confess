import { handleClick } from "../../../sweetalert";

// ---------------------------------
// Confession category
document.documentElement.addEventListener("click", function (event) {
    const unique = event.target.dataset.unique ?? "";

    // Destroy
    if (
        event.target &&
        event.target.matches("[data-confirm-confession-category-destroy]")
    )
        handleClick({
            data: { unique },
            event: {
                noun: "kategori pengakuan",
                verb: "menonaktifkan",
                method: "DELETE",
            },
            uri: {
                url: "/dashboard/confessions/confession-categories",
            },
            redirect: `/dashboard/confessions/confession-categories`,
        });

    // Destroy (image)
    if (
        event.target &&
        event.target.matches("[data-confirm-confession-category-image-destroy]")
    )
        handleClick({
            data: { unique },
            event: {
                noun: "foto kategori pengakuan",
                verb: "hapus",
                method: "DELETE",
            },
            uri: {
                url: "/dashboard/confessions/confession-categories",
                noun: "image",
            },
            redirect: `/dashboard/confessions/confession-categories`,
        });

    // Activate
    if (
        event.target &&
        event.target.matches("[data-confirm-confession-category-activate]")
    )
        handleClick({
            data: { unique },
            event: {
                noun: "kategori pengakuan",
                verb: "mengaktivasi",
                method: "PUT",
            },
            uri: {
                url: "/dashboard/confessions/confession-categories",
                noun: "activate",
            },
            redirect: `/dashboard/confessions/confession-categories`,
        });
});
