const checkbox = document.getElementById("iaggree");
const buttonDeleteAccount = document.getElementById(
    "btn-non-active-your-account"
);
checkbox.addEventListener("change", function () {
    const checked = checkbox.checked;
    if (checked) buttonDeleteAccount.removeAttribute("disabled");
    else buttonDeleteAccount.setAttribute("disabled", true);
});
