// Image preview and Sluggable
// Sluggable
let title = document.querySelector("#title");
let slug = document.querySelector("#slug");

title.addEventListener("change", function () {
    if (!title.value) {
        slug.value = "";
    } else {
        fetch(`/dashboard/complaints/checkSlug?title=${title.value}`)
            .then((response) => response.json())
            .then((data) => {
                slug.value = data.slug;
            });
    }
});

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
