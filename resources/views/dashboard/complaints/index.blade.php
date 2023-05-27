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
                        <a data-bs-toggle="tooltip" data-bs-original-title="Buat keluhan yang kamu alami."
                            href="/dashboard/complaints/create" class="btn btn-success px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
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
                                Keluhan
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
                                            @if ($complaint->status == 2)
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Rincian dari keluhan kamu yang sudah selesai."
                                                    href="/dashboard/complaints/{{ $complaint->slug }}"
                                                    class="btn btn-info px-2 pt-2">
                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            @elseif($complaint->status < 2)
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Lakukan penyuntingan terhadap keluhan kamu."
                                                        href="/dashboard/complaints/{{ $complaint->slug }}/edit"
                                                        class="btn btn-warning px-2 pt-2">
                                                        <span class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Rincian dari keluhan kamu."
                                                        href="/dashboard/complaints/{{ $complaint->slug }}"
                                                        class="btn btn-info px-2 pt-2">
                                                        <span class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Hapus keluhan yang kamu miliki."
                                                        href="#" class="btn btn-danger px-2 pt-2 delete-record"
                                                        data-slug="{{ $complaint->slug }}">
                                                        <span data-slug="{{ $complaint->slug }}"
                                                            class="delete-record fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-center mt-3">Tidak ada keluhan :(</p>
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
    @vite(['resources/js/simple-datatable/complaints.js'])
@endsection
