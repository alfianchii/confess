const navBar = document.getElementById("navbar");
const navCont = document.getElementById("navCont");

function scroll() {
    let calc = window.scrollY; // mendapatkan posisi scroll dari atas ke bawah
    if (calc > 250) {
        // jika posisi scroll lebih dari 0 pixel
        navBar.classList.replace("bg-transparent", "bg-nav");
    } else if (calc <= 250) {
        // jika posisi scroll sama dengan 0 pixel
        navBar.classList.replace("bg-nav", "bg-transparent");
    }
}

//panggil saat inisialisasi
scroll();

// panggil saat discroll
window.onscroll = () => {
    scroll();
};

const nav = document.querySelector(".navbar");
let showTimeout = null;

window.addEventListener("scroll", function () {
    hideNav();

    if (showTimeout !== null) {
        this.clearTimeout(showTimeout);
    }
    showTimeout = this.setTimeout(showNav, 100);
});

function hideNav() {
    nav.style.top = "-100px";
}
function showNav() {
    nav.style.top = "0";
}
