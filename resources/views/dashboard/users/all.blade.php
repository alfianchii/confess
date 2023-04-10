@extends('dashboard.layouts.main')

@section('links')
    {{-- Simple DataTable --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable.css') }}" />
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Daftar Pengguna</h2>
                    <p class="text-subtitle text-muted">
                        Keseluruhan data setiap pengguna.
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
                                User
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3>Pengguna</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table4">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @if ($user->image)
                                            <img class="rounded" width="100" src="{{ asset("storage/$user->image") }}"
                                                alt="Foto">
                                        @else
                                            Tidak ada
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        @if ($user->level === 'student')
                                            <span class="badge bg-success">
                                                Student
                                            </span>
                                        @elseif($user->level === 'officer')
                                            <span class="badge bg-warning">
                                                Officer
                                            </span>
                                        @elseif($user->level === 'admin')
                                            <span class="badge bg-info">
                                                Admin
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-2">
                                                <a href="/dashboard/users/{{ $user->username }}" class="badge bg-info"><span
                                                        data-feather="eye"></span></a>
                                            </div>
                                            <div class="me-2">
                                                <a href="/dashboard/users/{{ $user->username }}/edit"
                                                    class="badge bg-warning"><span data-feather="edit"></span></a>
                                            </div>
                                            <div class="me-2">
                                                <a href="#" class="badge bg-danger border-0 delete-record"
                                                    data-slug="{{ $user->username }}"><span data-feather="x-circle"
                                                        class="delete-record" data-slug="{{ $user->username }}"></span></a>
                                            </div>

                                            @if ($user->level === 'admin')
                                                <div class="me-2">
                                                    <button data-user="{{ $user->username }}" type="submit"
                                                        class="btn bg-secondary px-2 pt-2 text-white demote-record">
                                                        <span data-user="{{ $user->username }}"
                                                            class="fa-fw fa-lg select-all fas demote-record"></span>
                                                    </button>
                                                </div>
                                            @elseif ($user->level === 'officer')
                                                <div class="me-2">
                                                    <button data-user="{{ $user->username }}" type="submit"
                                                        class="btn bg-primary px-2 pt-2 text-white promote-record">
                                                        <span data-user="{{ $user->username }}"
                                                            class="fa-fw fa-lg select-all fas promote-record"></span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-center mt-3">Tidak ada pengguna</p>
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
        /* USER TABLE */
        let dataTable = new simpleDatatables.DataTable(
            document.getElementById("table4"), {
                perPage: 3,
                perPageSelect: [3, 10, 25, 50],
                labels: {
                    placeholder: "Cari ...",
                    noRows: "Tidak ada tanggapan",
                    info: "Menampilkan {start} hingga {end} dari {rows} tanggapan",
                    perPage: "{select} tanggapan per halaman",
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
