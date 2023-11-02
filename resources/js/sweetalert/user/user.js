import { handleClick } from "../../sweetalert";

// ---------------------------------
// User
document.documentElement.addEventListener("click", function (event) {
    const unique = event.target.dataset.unique ?? "";

    // Destroy
    if (event.target && event.target.matches("[data-confirm-user-destroy]"))
        handleClick({
            data: { unique },
            event: {
                noun: "akun",
                verb: "menonaktifkan",
                method: "DELETE",
            },
            uri: {
                url: `/dashboard/users`,
            },
            redirect: "/dashboard/users",
        });

    // Destroy (profile picture)
    if (
        event.target &&
        event.target.matches("[data-confirm-user-profile-picture-destroy]")
    )
        handleClick({
            data: { unique },
            event: {
                noun: "foto profil",
                verb: "hapus",
                method: "DELETE",
            },
            uri: {
                url: `/dashboard/users/account/settings`,
                noun: `profile-picture`,
            },
            redirect: "/dashboard",
        });

    // Activate
    if (event.target && event.target.matches("[data-confirm-user-activate]"))
        handleClick({
            data: { unique },
            event: {
                noun: "akun",
                verb: "mengaktifkan",
                method: "PUT",
            },
            uri: {
                url: `/dashboard/users`,
                noun: `activate`,
            },
            redirect: "/dashboard/users",
        });

    // Non-active
    if (event.target && event.target.matches("[data-confirm-user-non-active]"))
        handleClick({
            data: { unique },
            event: {
                noun: "akunmu",
                verb: "menonaktifkan",
                method: "DELETE",
            },
            uri: {
                url: `/dashboard/users/account`,
                noun: `non-active`,
            },
            redirect: "/",
        });
});
