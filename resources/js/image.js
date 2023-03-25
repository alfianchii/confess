// Image Preview
const imageInput = document.getElementById("image");
imageInput.addEventListener("change", function () {
    let image = document.querySelector("#image");
    let imagePreview = document.querySelector(".img-preview");

    imagePreview.style.display = "block";
    imagePreview.alt = "Foto Keluhan";

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function (oFREvent) {
        imagePreview.src = oFREvent.target.result;
    };
});
