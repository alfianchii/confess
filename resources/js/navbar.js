const navBar = document.getElementById("navbar");
const hamburgerBtn = document.querySelector(".navbar-toggler");
hamburgerBtn.addEventListener("click", function () {
    navBar.classList.toggle("active");
});
function scroll() {
    let calc = window.scrollY;
    if (calc > 180) {
        navBar.classList.replace("bg-transparent", "bg-nav");
    } else if (calc <= 180) {
        navBar.classList.replace("bg-nav", "bg-transparent");
    }
}

// Panggil saat inisialisasi
// scroll();

// panggil saat discroll
// window.onscroll = () => {
//     scroll();
// };
