import { handleClick } from "../../../sweetalert";

// ---------------------------------
// Confession's comment
document.documentElement.addEventListener("click", function (event) {
    const unique = event.target.dataset.unique ?? "";
    const redirect = event.target.dataset.redirect ?? "";

    // Destroy
    if (
        event.target &&
        event.target.matches("[data-confirm-confession-comment-destroy]")
    )
        handleClick({
            data: { unique },
            event: {
                noun: "komentar",
                verb: "unsend",
                method: "DELETE",
            },
            uri: {
                url: "/comments",
            },
            redirect: `/confessions/${atob(
                redirect
            )}/comments/create?scroll-to=comments`,
        });

    // Destroy (attachment)
    if (
        event.target &&
        event.target.matches(
            "[data-confirm-confession-comment-attachment-destroy]"
        )
    )
        handleClick({
            data: { unique },
            event: {
                noun: "file pendukung",
                verb: "unsend",
                method: "DELETE",
            },
            uri: {
                url: "/comments",
                noun: "attachment",
            },
            redirect: `/confessions/${atob(
                redirect
            )}/comments/create?comment=${unique}`,
        });
});
