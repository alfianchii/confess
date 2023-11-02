import { handleClick } from "../../sweetalert";

// ---------------------------------
// Confession
document.documentElement.addEventListener("click", function (event) {
    const unique = event.target.dataset.unique ?? "";
    const redirect = event.target.dataset.redirect ?? "";

    // Destroy
    if (
        event.target &&
        event.target.matches("[data-confirm-confession-destroy]")
    )
        handleClick({
            data: { unique },
            event: {
                noun: "confession",
                verb: "unsend",
                method: "DELETE",
            },
            uri: {
                url: "/dashboard/confessions",
            },
            redirect: "/dashboard/confessions",
        });

    // Destroy (image)
    if (
        event.target &&
        event.target.matches("[data-confirm-confession-image-destroy]")
    )
        handleClick({
            data: { unique },
            event: {
                noun: "foto pengakuan",
                verb: "unsend",
                method: "DELETE",
            },
            uri: {
                url: "/dashboard/confessions",
                noun: "image",
            },
            redirect: `/dashboard/confessions/${atob(
                redirect
            )}/responses/create`,
        });

    // Pick
    if (event.target && event.target.matches("[data-confirm-confession-pick]"))
        handleClick({
            data: { unique },
            event: {
                noun: "confession",
                verb: "pick",
                method: "PUT",
            },
            uri: {
                url: "/dashboard/confessions",
                noun: "pick",
            },
            redirect: `/dashboard/confessions/${atob(unique)}/responses/create`,
        });

    // Release
    if (
        event.target &&
        event.target.matches("[data-confirm-confession-release]")
    )
        handleClick({
            data: { unique },
            event: {
                noun: "confession",
                verb: "release",
                method: "PUT",
            },
            uri: {
                url: "/dashboard/confessions",
                noun: "release",
            },
            redirect: `/dashboard/confessions`,
        });

    // Close
    if (event.target && event.target.matches("[data-confirm-confession-close]"))
        handleClick({
            data: { unique },
            event: {
                noun: "confession",
                verb: "close",
                method: "PUT",
            },
            uri: {
                url: "/dashboard/confessions",
                noun: "close",
            },
            redirect: `/dashboard/confessions`,
        });
});
