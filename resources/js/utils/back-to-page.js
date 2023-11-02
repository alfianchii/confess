// On click backToPage, then redirect to the previous url based on object history
const backToPage = document.getElementById("back-to-page-button");

// Back to the previous page and hard refresh its page
backToPage.addEventListener("click", () => {
    window.history.back();
    // window.location.href = document.referrer;
});
