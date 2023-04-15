import { displayPassword } from "../display-password";

let currentPw = document.getElementById("current_password");
let newPw = document.getElementById("new_password");
let checkbox = document.getElementById("show_change_pw");

displayPassword(currentPw, checkbox);
displayPassword(newPw, checkbox);
