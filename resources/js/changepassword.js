let currentPw = document.getElementById("current_password");
let newPw = document.getElementById("new_password");
let checkbox = document.getElementById("show_change_pw");
let label = document.getElementById("label-show_pw");

checkbox.addEventListener("click", () => {
    showChangePassword();
});

function showChangePassword() {
    if (currentPw.type === "password" && newPw.type === "password") {
        currentPw.type = "text";
        newPw.type = "text";
        label.innerText = "Sembunyikan Password";
    } else {
        currentPw.type = "password";
        newPw.type = "password";
        label.innerText = "Tampilkan Password";
    }
}
console.log("tes");
