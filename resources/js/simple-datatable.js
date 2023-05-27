import { tooltip } from "../js/tooltip";

export function simpleDatatable(
    table = "table1",
    perPageData = 10,
    perPageSelectData = [5, 10, 15, 20, 25],
    label = "data",
    isTooltip = false,
    maxPagination = 3,
    isSearch = false
) {
    let dataTable = new simpleDatatables.DataTable(
        document.getElementById(`${table}`),
        {
            perPage: perPageData,
            perPageSelect: perPageSelectData,
            labels: {
                placeholder: "Cari ...",
                noRows: `Tidak ada ${label}`,
                info: `Menampilkan {start} hingga {end} dari {rows} ${label}`,
                perPage: `{select} ${label} per halaman`,
            },
            fixedHeight: true,
        }
    );

    // Get datatable-input and changes its own value from url
    if (isSearch) {
        const searchInput = document.querySelector(".dataTable-input");
        const urlParams = new URLSearchParams(window.location.search);
        const values = urlParams.values();

        for (const value of values) {
            searchInput.value = value;

            // Then click enter on search input
            const event = new KeyboardEvent("keyup", { keyCode: 13 });
            searchInput.dispatchEvent(event);
        }
    }

    // Move "per page dropdown" selector element out of label
    // to make it work with bootstrap 5. Add bs5 classes.
    function adaptPageDropdown() {
        const selector = dataTable.wrapper.querySelector(".dataTable-selector");
        selector.parentNode.parentNode.insertBefore(
            selector,
            selector.parentNode
        );
        selector.classList.add("form-select");
    }

    // Add bs5 classes to pagination elements
    function adaptPagination() {
        // Limit the number of page links displayed
        const currentPage = dataTable.currentPage;
        const totalPages = dataTable.totalPages;
        const startPage = Math.max(
            1,
            currentPage - Math.floor(maxPagination / 2)
        );
        const endPage = Math.min(totalPages, startPage + maxPagination - 1);

        const paginations = dataTable.wrapper.querySelectorAll(
            "ul.dataTable-pagination-list"
        );

        for (const pagination of paginations) {
            pagination.classList.add(...["pagination", "pagination-primary"]);
        }

        const paginationLis = dataTable.wrapper.querySelectorAll(
            "ul.dataTable-pagination-list li"
        );

        for (const paginationLi of paginationLis) {
            paginationLi.classList.add("page-item");
        }

        const paginationLinks = dataTable.wrapper.querySelectorAll(
            "ul.dataTable-pagination-list li a"
        );

        for (const paginationLink of paginationLinks) {
            paginationLink.classList.add("page-link");

            // Take the current page number from the data-page attribute
            const page = parseInt(paginationLink.dataset.page);

            // Remove ellipsis
            if (paginationLink.parentNode.classList.contains("ellipsis")) {
                paginationLink.parentNode.classList.add("d-none");
            }

            // Hide pages that are not in the range
            if (page < startPage || page > endPage) {
                paginationLink.parentNode.classList.add("d-none");

                // Show ellipsis as first page
                if (paginationLink.dataset.page == 1) {
                    paginationLink.parentNode.classList.replace(
                        "d-none",
                        "d-block"
                    );
                    paginationLink.innerHTML = "«";
                }

                // Show ellipsis as last page
                if (paginationLink.dataset.page == totalPages) {
                    paginationLink.parentNode.classList.replace(
                        "d-none",
                        "d-block"
                    );
                    paginationLink.innerHTML = "»";
                }
            } else {
                // Show pages that are in the range
                paginationLink.parentNode.classList.add("d-block");
            }
        }
    }

    const refreshPagination = () => adaptPagination();

    // Patch "per page dropdown" and pagination after table rendered
    dataTable.on("datatable.init", () => {
        adaptPageDropdown();
        refreshPagination();
    });
    dataTable.on("datatable.update", refreshPagination);
    dataTable.on("datatable.sort", refreshPagination);

    // Re-patch pagination after the page was changed
    dataTable.on("datatable.page", adaptPagination);

    // Tooltip
    if (isTooltip) {
        dataTable.on("datatable.update", tooltip);
        dataTable.on("datatable.sort", tooltip);
        dataTable.on("datatable.page", tooltip);
    }
}
