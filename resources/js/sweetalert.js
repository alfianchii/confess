export function handleClick({ data, event, uri, redirect = uri }) {
    const config = {
        title: "Apakah kamu yakin?",
        text: `Kamu akan ${event.verb} ${event.noun} ini.`,
        icon: "question",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Yup, do it!",
        denyButtonText: `Nope ...`,
    };

    // If unique is string, don't decode
    const isUniqueInt = parseInt(atob(data.unique));
    if (!isUniqueInt) data.unique = atob(data.unique);

    // Do fire first
    Swal.fire(config).then(async (result) => {
        if (result.isConfirmed) {
            // URLs
            let url = ``;
            if (uri.noun) url = `${uri.url}/${data.unique}/${uri.noun}`;
            if (!uri.noun) url = `${uri.url}/${data.unique}`;

            const req = await fetch(url, {
                method: event.method,
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify(data),
            });

            const res = await req.json();

            const message = res.message;
            const successResponse = {
                title: "Success!",
                text: message,
                icon: "success",
            };
            const errorResponse = {
                title: "Error!",
                text: message,
                icon: "error",
            };

            // Show a success message using SweetAlert2
            if (req.ok)
                return Swal.fire(successResponse).then(
                    () => (window.location.href = redirect)
                );

            // Show an error message using SweetAlert2
            return Swal.fire(errorResponse).then(
                () => (window.location.href = redirect)
            );
        }
    });
}
