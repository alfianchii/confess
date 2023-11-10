// User's session
import userSession from "./helpers/user-session";

export async function initDashboard() {
    return await fetch(`/dashboard/chart-data`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify(userSession),
    })
        .then(async (result) => await result.json())
        .finally(() => {
            // Hide loading
            let skeletonLoadings =
                document.querySelectorAll(".skeleton-loading");

            skeletonLoadings.forEach((skeletonLoading) => {
                skeletonLoading.classList.add("d-none");
            });
        });
}
