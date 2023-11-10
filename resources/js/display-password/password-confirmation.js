import { displayPassword } from "../display-password";

let password = document.getElementById("password");
let passwordButton = document.getElementById("show-password");
let passwordConfirmation = document.getElementById("password-confirmation");
let passwordConfirmationButton = document.getElementById(
    "show-password-confirmation"
);

displayPassword(password, passwordButton);
displayPassword(passwordConfirmation, passwordConfirmationButton);
