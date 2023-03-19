@extends('dashboard.layouts.main')

@section('links')
    {{-- Simple DataTable --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}" />
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>{{ $greeting }}, {{ auth()->user()->name }}!</h2>
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
        <div class="page-content mt-4">
            <section class="row">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple mb-2">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Keluhan
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                                {{ $complaints->count() }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon blue mb-2">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Pegawai
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                                {{ $officers->count() }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon green mb-2">
                                                <i class="iconly-boldAdd-User"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Murid
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                                {{ $students->count() }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon red mb-2">
                                                <i class="iconly-boldBookmark"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Tanggapan
                                            </h6>
                                            <h6 class="font-extrabold mb-0">
                                                {{ $responses->count() }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Tanggapan</h3>
                                </div>
                                <div class="card-body">
                                    <div id="chart-profile-visit"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Keluhan</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped" id="table2">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Judul Keluhan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($complaints as $complaint)
                                                <tr>
                                                    <td>
                                                        <p>{{ $loop->iteration }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="m-0">{{ $complaint->title }}</p>
                                                    </td>
                                                    <td>
                                                        @if ($complaint->status == 0)
                                                            <span class="badge bg-danger">
                                                                Belum diproses
                                                            </span>
                                                        @elseif ($complaint->status == 1)
                                                            <span class="badge bg-secondary">
                                                                Sedang diproses
                                                            </span>
                                                        @elseif ($complaint->status == 2)
                                                            <span class="badge bg-success">
                                                                Selesai
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            @if ($complaint->status == 2)
                                                                <span class="badge bg-success">
                                                                    Kasus Selesai
                                                                </span>
                                                            @elseif($complaint->status < 2)
                                                                <div class="me-2">
                                                                    <a href="/dashboard/responses/create/{{ $complaint->slug }}"
                                                                        class="btn btn-warning">
                                                                        <i class="bi bi-pencil-square"></i> Tanggapi
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">
                                                        <p class="text-center mt-3">Tidak ada tanggapan</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-body py-4 px-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl">
                                    <img src="assets/images/faces/1.jpg" alt="Face 1" />
                                </div>
                                <div class="ms-3 name">
                                    <h5 class="font-bold">{{ auth()->user()->name }}</h5>
                                    <h6 class="text-muted mb-0">
                                        {{ htmlspecialchars('@' . auth()->user()->username) }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Keluhan Terbaru</h4>
                        </div>
                        <div class="card-content pb-4">
                            @forelse ($complaints->where("status", "!=", '2')->slice(0, 3) as $complaint)
                                <a href="/dashboard/responses/create/{{ $complaint->slug }}">
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="avatar avatar-lg">
                                            @if ($complaint->student->user->image)
                                                <img src="{{ asset('storage/' . $complaint->student->user->image) }}"
                                                    alt="User avatar" />
                                            @else
                                                @if ($complaint->student->user->gender == 'L')
                                                    <img src="{{ asset('assets/images/faces/2.jpg') }}"
                                                        alt="User avatar" />
                                                @else
                                                    <img src="{{ asset('assets/images/faces/5.jpg') }}"
                                                        alt="User avatar" />
                                                @endif
                                            @endif
                                        </div>
                                        <div class="name ms-4">
                                            <h5 class="mb-1">{{ $complaint->student->user->name }}</h5>
                                            <h6 class="text-muted mb-0">
                                                {{ htmlspecialchars('@' . $complaint->student->user->username) }}
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="recent-message d-flex px-4 py-3">
                                    <div class="alert alert-warning" role="alert">
                                        <h4 class="alert-heading">Tidak ada keluhan</h4>
                                    </div>
                                </div>
                            @endforelse
                            {{-- <div class="px-4">
                                <button class="btn btn-block btn-xl btn-outline-primary font-bold mt-3">
                                    Start Conversation
                                </button>
                            </div> --}}
                        </div>
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
