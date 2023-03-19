@extends('dashboard.layouts.main')

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Selamat datang, {{ auth()->user()->name }}!</h3>
                    <p class="text-subtitle text-muted">
                        Lorem, ipsum dolor sit amet
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                Dashboard
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">About Vertical Navbar</h4>
                </div>
                <div class="card-body">
                    <p>
                        Vertical Navbar is a layout option that you can use with
                        Mazer.
                    </p>

                    <p>
                        In case you want the navbar to be sticky on top while
                        scrolling, add <code>.navbar-fixed</code> class alongside
                        with <code>.layout-navbar</code> class.
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">About Vertical Navbar</h4>
                </div>
                <div class="card-body">
                    <p>
                        Vertical Navbar is a layout option that you can use with
                        Mazer.
                    </p>

                    <p>
                        In case you want the navbar to be sticky on top while
                        scrolling, add <code>.navbar-fixed</code> class alongside
                        with <code>.layout-navbar</code> class.
                    </p>
                </div>
            </div>
        </section>
    </div>
    </div>
@endsection

@section('scripts')
    <!-- Need: Apexcharts -->
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    {{-- Dashboard --}}
    <script>
        fetch(`/dashboard/responses-data`, {
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        }).then(async (result) => {
            const body = await result.json();

            const records = body.data.yAxis
            const labels = body.data.xAxis
            const genders = body.data.genders

            // Convert string to int
            for (const gender in genders) {
                genders[gender] = parseInt(genders[gender]);
            }

            var optionsProfileVisit = {
                annotations: {
                    position: "back",
                },
                dataLabels: {
                    enabled: false,
                },
                chart: {
                    type: "bar",
                    height: 300,
                },
                fill: {
                    opacity: 1,
                },
                plotOptions: {},
                series: [{
                    name: "tanggapan",
                    data: records,
                }, ],
                colors: "#435ebe",
                xaxis: {
                    categories: labels,
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            if (value < 5) {
                                return Math.round(value);
                            }
                            return value;
                        }
                    }
                }
            }
            let optionsVisitorsProfile = {
                series: [genders.male, genders.female],
                labels: ["Male", "Female"],
                colors: ["#435ebe", "#55c6e8"],
                chart: {
                    type: "donut",
                    width: "100%",
                    height: "350px",
                },
                legend: {
                    position: "bottom",
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "30%",
                        },
                    },
                },
            }

            var chartProfileVisit = new ApexCharts(
                document.querySelector("#chart-profile-visit"),
                optionsProfileVisit
            )
            var chartVisitorsProfile = new ApexCharts(
                document.getElementById("chart-visitors-profile"),
                optionsVisitorsProfile
            )

            chartProfileVisit.render()
            chartVisitorsProfile.render()
        })
    </script>
    {{-- Simple DataTable --}}
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script>
        /* RESPONSE TABLE */
        let responseTable = new simpleDatatables.DataTable(
            document.getElementById("table2"), {
                perPage: 3,
                perPageSelect: [3, 10, 25, 50],
                labels: {
                    placeholder: "Cari ...",
                    noRows: "Tidak ada keluhan",
                    info: "Menampilkan {start} hingga {end} dari {rows} keluhan",
                    perPage: "{select} keluhan per halaman",
                },
            }
        );

        // Move "per page dropdown" selector element out of label
        // to make it work with bootstrap 5. Add bs5 classes.
        function adaptPageDropdown() {
            const selector = responseTable.wrapper.querySelector(".dataTable-selector");
            selector.parentNode.parentNode.insertBefore(selector, selector.parentNode);
            selector.classList.add("form-select");
        }

        // Add bs5 classes to pagination elements
        function adaptPagination() {
            const paginations = responseTable.wrapper.querySelectorAll(
                "ul.dataTable-pagination-list"
            );

            for (const pagination of paginations) {
                pagination.classList.add(...["pagination", "pagination-primary"]);
            }

            const paginationLis = responseTable.wrapper.querySelectorAll(
                "ul.dataTable-pagination-list li"
            );

            for (const paginationLi of paginationLis) {
                paginationLi.classList.add("page-item");
            }

            const paginationLinks = responseTable.wrapper.querySelectorAll(
                "ul.dataTable-pagination-list li a"
            );

            for (const paginationLink of paginationLinks) {
                paginationLink.classList.add("page-link");
            }
        }

        // Patch "per page dropdown" and pagination after table rendered
        responseTable.on("datatable.init", function() {
            adaptPageDropdown();
            adaptPagination();
        });

        // Re-patch pagination after the page was changed
        responseTable.on("datatable.page", adaptPagination);
    </script>
@endsection
