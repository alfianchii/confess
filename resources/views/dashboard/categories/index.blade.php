@extends('dashboard.layouts.main')

@section('links')
    {{-- Simple DataTable --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable.css') }}" />
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    {{-- Fontawesome --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Semua Kategori</h2>
                    <p class="text-subtitle text-muted">
                        Keseluruhan data dari kategori untuk keluhan.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <button type="submit" class="btn btn-success px-3 py-2">
                            <a href="/dashboard/categories/create" class="text-white">
                                <span class="fa-fw select-all fas"></span> Buat Kategori
                            </a>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Complaints
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3>Keluhan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>
                                        <p>{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p class="m-0">{{ $category->name }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-2">
                                                <a href="/dashboard/categories/{{ $category->slug }}/edit"
                                                    class="badge bg-warning"><span data-feather="edit"></span></a>
                                            </div>
                                            <div class="me-2">
                                                <a href="#" class="badge bg-danger border-0 delete-record"
                                                    data-slug="{{ $category->slug }}"><span data-feather="x-circle"
                                                        class="delete-record" data-slug="{{ $category->slug }}"></span></a>
                                            </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-center mt-3">Tidak ada keluhan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/swalMulti.js'])
    {{-- Simple DataTable --}}
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script>
        // COMPLAINT TABLE
        let complaintTable = new simpleDatatables.DataTable(
            document.getElementById("table3"), {
                perPage: 3,
                perPageSelect: [3, 10, 25, 50],
                labels: {
                    placeholder: "Cari ...",
                    noRows: "Tidak ada kategori",
                    info: "Menampilkan {start} hingga {end} dari {rows} kategori",
                    perPage: "{select} kategori per halaman",
                },
            }
        );

        // Move "per page dropdown" selector element out of label
        // to make it work with bootstrap 5. Add bs5 classes.
        function adaptPageDropdown() {
            const selector = complaintTable.wrapper.querySelector(
                ".dataTable-selector"
            );
            selector.parentNode.parentNode.insertBefore(selector, selector.parentNode);
            selector.classList.add("form-select");
        }

        // Add bs5 classes to pagination elements
        function adaptPagination() {
            const paginations = complaintTable.wrapper.querySelectorAll(
                "ul.dataTable-pagination-list"
            );

            for (const pagination of paginations) {
                pagination.classList.add(...["pagination", "pagination-primary"]);
            }

            const paginationLis = complaintTable.wrapper.querySelectorAll(
                "ul.dataTable-pagination-list li"
            );

            for (const paginationLi of paginationLis) {
                paginationLi.classList.add("page-item");
            }

            const paginationLinks = complaintTable.wrapper.querySelectorAll(
                "ul.dataTable-pagination-list li a"
            );

            for (const paginationLink of paginationLinks) {
                paginationLink.classList.add("page-link");
            }
        }

        // Patch "per page dropdown" and pagination after table rendered
        complaintTable.on("datatable.init", function() {
            adaptPageDropdown();
            adaptPagination();
        });

        // Re-patch pagination after the page was changed
        complaintTable.on("datatable.page", adaptPagination);
    </script>
@endsection
