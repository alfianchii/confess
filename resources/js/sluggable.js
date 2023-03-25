// Sluggable
export function sluggable(input, sluggable, uri) {
    let slug = document.querySelector("#slug");

    input.addEventListener("change", function () {
        if (!input.value) {
            slug.value = "";
        } else {
            fetch(`${uri}/checkSlug?${sluggable}=${input.value}`)
                .then((response) => response.json())
                .then((data) => {
                    slug.value = data.slug;
                });
        }
    });
}
