@extends('dashboard.layouts.main')

@section('links')
    {{-- Simple DataTable --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable.css') }}" />
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Semua Keluhan Kamu</h2>
                    <p class="text-subtitle text-muted">
                        Keseluruhan data dari keluhan kamu.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="/dashboard/complaints/create" class="btn btn-success">
                            <i class="bi bi-envelope-paper-heart me-1"></i> Buat Keluhan
                        </a>
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
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($complaints as $complaint)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $complaint->title }}
                                    </td>
                                    <td>
                                        {{ $complaint->category->name }}
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
                                            <div class="me-2">
                                                <a href="/dashboard/complaints/{{ $complaint->slug }}"
                                                    class="badge bg-info"><span data-feather="eye"></span></a>
                                            </div>
                                            <div class="me-2">
                                                <a href="/dashboard/complaints/{{ $complaint->slug }}/edit"
                                                    class="badge bg-warning"><span data-feather="edit"></span></a>
                                            </div>
                                            <div class="me-2">
                                                <a href="#" class="badge bg-danger border-0 delete-record"
                                                    data-slug="{{ $complaint->slug }}"><span data-feather="x-circle"
                                                        class="delete-record" data-slug="{{ $complaint->slug }}"></span></a>
                                            </div>
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
        /* COMPLAINT TABLE */
        let dataTable = new simpleDatatables.DataTable(
            document.getElementById("table1"), {
                perPage: 3,
                perPageSelect: [3, 10, 25, 50],
                labels: {
                    placeholder: "Cari ...",
                    noRows: "Tidak ada keluhan",
                    info: "Menampilkan {start} hingga {end} dari {rows} keluhan",
                    perPage: "{select} keluhan per halaman",
                },
            }
        )
        // Move "per page dropdown" selector element out of label
        // to make it work with bootstrap 5. Add bs5 classes.
        function adaptPageDropdown() {
            const selector = dataTable.wrapper.querySelector(".dataTable-selector")
            selector.parentNode.parentNode.insertBefore(selector, selector.parentNode)
            selector.classList.add("form-select")
        }

        // Add bs5 classes to pagination elements
        function adaptPagination() {
            const paginations = dataTable.wrapper.querySelectorAll(
                "ul.dataTable-pagination-list"
            )

            for (const pagination of paginations) {
                pagination.classList.add(...["pagination", "pagination-primary"])
            }

            const paginationLis = dataTable.wrapper.querySelectorAll(
                "ul.dataTable-pagination-list li"
            )

            for (const paginationLi of paginationLis) {
                paginationLi.classList.add("page-item")
            }

            const paginationLinks = dataTable.wrapper.querySelectorAll(
                "ul.dataTable-pagination-list li a"
            )

            for (const paginationLink of paginationLinks) {
                paginationLink.classList.add("page-link")
            }
        }

        const refreshPagination = () => {
            adaptPagination()
        }

        // Patch "per page dropdown" and pagination after table rendered
        dataTable.on("datatable.init", () => {
            adaptPageDropdown()
            refreshPagination()
        })
        dataTable.on("datatable.update", refreshPagination)
        dataTable.on("datatable.sort", refreshPagination)

        // Re-patch pagination after the page was changed
        dataTable.on("datatable.page", adaptPagination)
    </script>
@endsection
