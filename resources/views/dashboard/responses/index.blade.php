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
                    <h2>Semua Tanggapan Kamu</h2>
                    <p class="text-subtitle text-muted">
                        Keseluruhan data dari tanggapan yang kamu buat.
                    </p>
                    <hr>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Responses
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3>Tanggapan</h3>
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
                            @forelse ($responses as $response)
                                <tr>
                                    <td>
                                        <p>{{ $loop->iteration }}</p>
                                    </td>
                                    <td>
                                        <p class="m-0">{{ $response->complaint->title }}</p>
                                    </td>
                                    <td>
                                        @if ($response->complaint->status == 0)
                                            <span class="badge bg-danger">
                                                Belum diproses
                                            </span>
                                        @elseif ($response->complaint->status == 1)
                                            <span class="badge bg-secondary">
                                                Sedang diproses
                                            </span>
                                        @elseif ($response->complaint->status == 2)
                                            <span class="badge bg-success">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @if ($response->complaint->status == 2)
                                                <a href="/dashboard/responses/create/{{ $response->complaint->slug }}"
                                                    class="btn btn-info">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                            @elseif($response->complaint->status < 2)
                                                <div class="me-2">
                                                    <a href="/dashboard/responses/{{ $response->id }}/edit"
                                                        class="badge bg-warning"><span data-feather="edit"></span></a>
                                                </div>

                                                <div class="me-2">
                                                    <a href="/dashboard/responses/{{ $response->id }}"
                                                        class="badge bg-info"><span data-feather="eye"></span></a>
                                                </div>

                                                <div class="me-2">
                                                    <a href="#" class="badge bg-danger border-0 delete-record"
                                                        data-slug="{{ $response->id }}"><span data-feather="x-circle"
                                                            class="delete-record"
                                                            data-slug="{{ $response->id }}"></span></a>
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
        /* RESPONSE TABLE */
        let responseTable = new simpleDatatables.DataTable(
            document.getElementById("table2"), {
                perPage: 3,
                perPageSelect: [3, 10, 25, 50],
                labels: {
                    placeholder: "Cari ...",
                    noRows: "Tidak ada tanggapan",
                    info: "Menampilkan {start} hingga {end} dari {rows} tanggapan",
                    perPage: "{select} tanggapan per halaman",
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
