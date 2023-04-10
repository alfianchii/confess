import { tooltip } from "../js/tooltip";

export function simpleDatatable(
    table = "table1",
    perPageData = 10,
    perPageSelectData = [5, 10, 15, 20, 25],
    label = "data",
    isTooltip = false
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
        }
    );

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
        }
    }

    const refreshPagination = () => {
        adaptPagination();
    };

    // Patch "per page dropdown" and pagination after table rendered
    dataTable.on("datatable.init", () => {
        adaptPageDropdown();
        refreshPagination();
    });
    dataTable.on("datatable.update", refreshPagination);
    dataTable.on("datatable.sort", refreshPagination);

    // Re-patch pagination after the page was changed
    dataTable.on("datatable.page", adaptPagination);
    if (isTooltip) {
        dataTable.on("datatable.page", tooltip);
    }
}
