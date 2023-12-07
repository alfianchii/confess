// ---------------------------------
// Based on element
export function scrollToWithElement(mainElementId, toScrollElement, position) {
    const mainElement = document.getElementById(mainElementId);
    const linkedElement = document.getElementById(toScrollElement);

    mainElement.addEventListener("click", function () {
        const tooltip = document.getElementsByClassName("tooltip")[0];
        const dataBsToggle = mainElement.getAttribute("data-bs-toggle") ?? "";
        const dataBsOriginalTitle =
            mainElement.getAttribute("data-bs-original-title") ?? "";

        if (tooltip) tooltip.style.display = "none";

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

        if (linkedElement) {
            const linkedElementTop =
                linkedElement.getBoundingClientRect().top + window.scrollY;
            const targetScrollPosition = linkedElementTop - position;

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
    const urlParams = new URLSearchParams(window.location.search).get(paramKey);
    const linkedElement = document.getElementById(urlParams);

    if (linkedElement) {
        const linkedElementTop =
            linkedElement.getBoundingClientRect().top + window.scrollY;
        const targetScrollPosition = linkedElementTop - position;

        window.scrollTo({
            top: targetScrollPosition,
            behavior: "smooth",
        });
    }
}
