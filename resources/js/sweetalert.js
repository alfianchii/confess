export function handleDelete(slug, event, uri, redirect = uri) {
    // Do fire first
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: `Kamu akan menghapus ${event} ini.`,
        icon: "question",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Ya, hapus!",
        denyButtonText: `Tidak ...`,
    }).then((result) => {
        if (result.isConfirmed) {
            // Send a DELETE request using fetch and handle the response
            fetch(`${uri}/${slug}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            }).then(async (response) => {
                const body = await response.json();
                const message = body.message;

                if (response.ok) {
                    // Show a success message using SweetAlert2
                    Swal.fire({
                        title: "Success!",
                        text: message,
                        icon: "success",
                    }).then(() => {
                        // Redirect to the dashboard page
                        window.location.href = redirect;
                    });
                } else {
                    // Show an error message using SweetAlert2
                    Swal.fire({
                        title: "Error!",
                        text: message,
                        icon: "error",
                    });
                }
            });
        }
    });
}

export function handlePromoteDemote(event, user, uri, redirect = uri) {
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: `Kamu akan melakukan ${event} pada pengguna @${user}.`,
        icon: "question",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: `Ya, ${event}!`,
        denyButtonText: `Tidak ...`,
    }).then((result) => {
        if (result.isConfirmed) {
            // Send a PUT request using fetch and handle the response
            fetch(`${uri}/${user}/${event}`, {
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            }).then(async (response) => {
                const body = await response.json();
                const message = body.message;
                if (response.ok) {
                    // Show a success message using SweetAlert2
                    Swal.fire({
                        title: "Success!",
                        text: message,
                        icon: "success",
                    }).then(() => {
                        // Redirect to the dashboard page
                        window.location.href = redirect;
                    });
                } else {
                    // Show an error message using SweetAlert2
                    Swal.fire({
                        title: "Error!",
                        text: message,
                        icon: "error",
                    });
                }
            });
        }
    });
}
