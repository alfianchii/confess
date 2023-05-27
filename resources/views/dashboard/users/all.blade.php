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
                                Pengguna
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
                    <table class="table table-striped" id="table1">
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
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Sunting pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                                    href="/dashboard/users/{{ $user->username }}/edit"
                                                    class="btn btn-warning px-2 pt-2">
                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Rincian dari pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                                    href="/dashboard/users/{{ $user->username }}"
                                                    class="btn btn-info px-2 pt-2">
                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Hapus pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                                    href="#" class="btn btn-danger px-2 pt-2 delete-record"
                                                    data-slug="{{ $user->username }}">
                                                    <span data-slug="{{ $user->username }}"
                                                        class="delete-record fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>

                                            {{-- Promote and demote --}}
                                            @if ($user->level === 'admin')
                                                <div class="me-2">
                                                    <button data-bs-toggle="tooltip"
                                                        data-bs-original-title="Demote pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                                        data-user="{{ $user->username }}" type="submit"
                                                        class="btn bg-secondary px-2 pt-2 text-white demote-record">
                                                        <span data-user="{{ $user->username }}"
                                                            class="text-white fa-fw fa-lg select-all fas demote-record"></span>
                                                    </button>
                                                </div>
                                            @elseif ($user->level === 'officer')
                                                <div class="me-2">
                                                    <button data-bs-toggle="tooltip"
                                                        data-bs-original-title="Promote pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                                        data-user="{{ $user->username }}" type="submit"
                                                        class="btn bg-primary px-2 pt-2 text-white promote-record">
                                                        <span data-user="{{ $user->username }}"
                                                            class="text-white fa-fw fa-lg select-all fas promote-record"></span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-center mt-3">Tidak ada pengguna :(</p>
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
    @vite(['resources/js/simple-datatable/user.js'])
@endsection
