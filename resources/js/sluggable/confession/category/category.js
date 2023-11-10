import { sluggable } from "../../../sluggable";

sluggable(
    document.querySelector("#category_name"),
    "category_name",
    "/dashboard/confessions/confession-categories"
);
