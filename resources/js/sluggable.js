import axios from "axios";
import userSession from "./helpers/user-session";

export function sluggable(input, sluggable, uri) {
    let slug = document.querySelector("#slug");

    input.addEventListener("change", async function () {
        if (!input.value) return (slug.value = "");

        const { data } = await axios.request({
            method: "post",
            url: `${uri}/check-slug?${sluggable}=${input.value}`,
            data: { userSession },
        });

        slug.value = data.slug;
    });
}
