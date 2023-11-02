// ---------------------------------
// Based on element
export function scrollToWithElement(mainElementId, toScrollElement, position) {
    // Get main element
    const mainElement = document.getElementById(mainElementId);
    // Take the data-scroll attribute of main element
    const linkedElement = document.getElementById(toScrollElement);

    // Add event listener to the main element
    mainElement.addEventListener("click", function () {
        // Make tooltip disappear and appear again
        const tooltip = document.getElementsByClassName("tooltip")[0];
        const dataBsToggle = mainElement.getAttribute("data-bs-toggle") ?? "";
        const dataBsOriginalTitle =
            mainElement.getAttribute("data-bs-original-title") ?? "";
        if (tooltip) {
            tooltip.style.display = "none";
        }
        mainElement.removeAttribute("aria-describedby");
        mainElement.removeAttribute("data-bs-toggle");
        mainElement.removeAttribute("data-bs-original-title");
        setTimeout(() => {
            mainElement.setAttribute("data-bs-toggle", dataBsToggle);
            mainElement.setAttribute(
                "data-bs-original-title",
                dataBsOriginalTitle
            );
        }, 100);

        // Scroll to the linked element
        if (linkedElement) {
            // The absolute top position of the linked element
            const linkedElementTop =
                linkedElement.getBoundingClientRect().top + window.scrollY;
            // The top position of the target scroll position
            const targetScrollPosition = linkedElementTop - position;

            // Scroll into linked element
            window.scrollTo({
                top: targetScrollPosition,
                behavior: "smooth",
            });
        }
    });
}

// ---------------------------------
// Based on url
export function scrollToWithUrl(paramKey, position) {
    // Get url params
    const urlParams = new URLSearchParams(window.location.search).get(paramKey);
    const linkedElement = document.getElementById(urlParams);

    // Scroll to the element
    if (linkedElement) {
        // The absolute top position of the linked element
        const linkedElementTop =
            linkedElement.getBoundingClientRect().top + window.scrollY;
        // The top position of the target scroll position
        const targetScrollPosition = linkedElementTop - position;

        // Scroll into linked element
        window.scrollTo({
            top: targetScrollPosition,
            behavior: "smooth",
        });
    }
}
