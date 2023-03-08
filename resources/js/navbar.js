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

//panggil saat inisialisasi
scroll();

// panggil saat discroll
window.onscroll = () => {
    scroll();
};

// const nav = document.querySelector(".navbar");
// let showTimeout = null;

// window.addEventListener("scroll", function () {
//     hideNav();

//     if (showTimeout !== null) {
//         this.clearTimeout(showTimeout);
//     }
//     showTimeout = this.setTimeout(showNav, 100);
// });

// function hideNav() {
//     nav.style.top = "-100px";
// }
// function showNav() {
//     nav.style.top = "0";
// }
