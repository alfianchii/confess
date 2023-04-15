let field = document.getElementById("password");
let btn = document.getElementById("show-btn");

btn.addEventListener("click", () => {
    showPassword();
});

let calc = window.innerWidth;
if (calc < 991) {
    btn.setAttribute("data-bs-toggle", "none");
}

function showPassword() {
    if (field.type === "password") {
        field.type = "text";
        btn.innerHTML = `<i class="bi bi-eye-slash-fill"></i>`;
    } else {
        field.type = "password";
        btn.innerHTML = `<i class="bi bi-eye-fill"></i>`;
    }
}

const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);
