export function displayPassword(field, btn) {
    btn.addEventListener("click", () => {
        if (field.type === "password") {
            field.type = "text";
            btn.innerHTML = `<i class="bi bi-eye-fill"></i>`;
        } else {
            field.type = "password";
            btn.innerHTML = `<i class="bi bi-eye-slash-fill"></i>`;
        }
    });
}
