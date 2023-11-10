import { handleClick } from "../../../sweetalert";

// ---------------------------------
// Confession's response
document.documentElement.addEventListener("click", function (event) {
    const unique = event.target.dataset.unique ?? "";
    const redirect = event.target.dataset.redirect ?? "";

    // Destroy
    if (
        event.target &&
        event.target.matches("[data-confirm-confession-response-destroy]")
    )
        handleClick({
            data: { unique },
            event: {
                noun: "tanggapan",
                verb: "unsend",
                method: "DELETE",
            },
            uri: {
                url: "/dashboard/responses",
            },
            redirect: `/dashboard/confessions/${atob(
                redirect
            )}/responses/create?scroll-to=responses`,
        });

    // Destroy (attachment)
    if (
        event.target &&
        event.target.matches(
            "[data-confirm-confession-response-attachment-destroy]"
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
                url: "/dashboard/responses",
                noun: "attachment",
            },
            redirect: `/dashboard/confessions/${atob(
                redirect
            )}/responses/create?response=${unique}`,
        });
});
