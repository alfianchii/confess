@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- Simple DataTable --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable.css') }}" />
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Pengakuan</h2>
                    <p class="text-subtitle text-muted">
                        Keseluruhan data dari pengakuan dengan status unprocess, process, release, dan close.
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
                                Pengakuan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        {{-- All of Confessions --}}
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between" style="row-gap: 1rem;">
                        <h3>All of Confessions</h3>

                        <div class="dropdown dropdown-color-icon mb-3 d-flex justify-content-start">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="export"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fa-fw select-all fas me-1"></span> Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="export">
                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="all-of-confessions">
                                    <input type="hidden" name="type" value="XLSX">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all far text-light"></span> Excel
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="all-of-confessions">
                                    <input type="hidden" name="type" value="CSV">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all fas text-light"></span> CSV
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="all-of-confessions">
                                    <input type="hidden" name="type" value="HTML">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all fab text-light"></span> HTML
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="all-of-confessions">
                                    <input type="hidden" name="type" value="MPDF">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all far text-light"></span> PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Kepemilikan</th>
                                <th>Kategori</th>
                                <th>Tanggapan</th>
                                <th>Komentar</th>
                                <th>Suka</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allConfessions as $confession)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $confession->title }}</td>
                                    <td>{{ $confession->student->user->full_name }}</td>
                                    <td>{{ $confession->category->category_name }}</td>
                                    <td>{{ $confession->responses->count() }}</td>
                                    <td>{{ $confession->comments->count() }}</td>
                                    <td>{{ $confession->likes->count() }}</td>
                                    <td>
                                        @if ($confession->status == 'unprocess')
                                            <span class="badge bg-light-danger">
                                                Belum diproses
                                            </span>
                                        @elseif ($confession->status == 'process')
                                            <span class="badge bg-light-info">
                                                Sedang diproses
                                            </span>
                                        @elseif ($confession->status == 'release')
                                            <span class="badge bg-light">
                                                Release
                                            </span>
                                        @elseif ($confession->status == 'close')
                                            <span class="badge bg-light-success">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            {{-- --------------------------------- Rules --}}
                                            @if ($confession->status === 'unprocess' || $confession->status === 'release')
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip" data-bs-original-title="Pick pengakuan ini."
                                                        href="#" class="btn btn-success px-2 pt-2"
                                                        data-confirm-confession-pick="true"
                                                        data-unique="{{ base64_encode($confession->slug) }}">
                                                        <span data-confirm-confession-pick="true"
                                                            data-unique="{{ base64_encode($confession->slug) }}"
                                                            class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                            @endif
                                            @if ($confession->status === 'process' && $confession->assigned_to === $userData->id_user)
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Release pengakuan yang lagi kamu handle."
                                                        href="#" class="btn btn-secondary px-2 pt-2"
                                                        data-confirm-confession-release="true"
                                                        data-unique="{{ base64_encode($confession->slug) }}">
                                                        <span data-confirm-confession-release="true"
                                                            data-unique="{{ base64_encode($confession->slug) }}"
                                                            class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Close pengakuan yang lagi kamu handle."
                                                        href="#" class="btn btn-danger px-2 pt-2"
                                                        data-confirm-confession-close="true"
                                                        data-unique="{{ base64_encode($confession->slug) }}">
                                                        <span data-confirm-confession-close="true"
                                                            data-unique="{{ base64_encode($confession->slug) }}"
                                                            class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Rincian dari suatu pengakuan."
                                                    href="/dashboard/confessions/{{ $confession->slug }}/responses/create"
                                                    class="btn btn-info px-2 pt-2">
                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <p class="text-center mt-3">Tidak ada pengakuan :(</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Confessions Handled by You --}}
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between" style="row-gap: 1rem;">
                        <h3>Confessions Handled by You</h3>

                        <div class="dropdown dropdown-color-icon mb-3 d-flex justify-content-start">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="export"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fa-fw select-all fas me-1"></span> Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="export">
                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="confessions-handled-by-you">
                                    <input type="hidden" name="type" value="XLSX">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all far text-light"></span> Excel
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="confessions-handled-by-you">
                                    <input type="hidden" name="type" value="CSV">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all fas text-light"></span> CSV
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="confessions-handled-by-you">
                                    <input type="hidden" name="type" value="HTML">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all fab text-light"></span> HTML
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="confessions-handled-by-you">
                                    <input type="hidden" name="type" value="MPDF">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all far text-light"></span> PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tanggapan</th>
                                <th>Komentar</th>
                                <th>Suka</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($confessionsHandledByYou as $confession)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $confession->title }}</td>
                                    <td>{{ $confession->category->category_name }}</td>
                                    <td>{{ $confession->responses->count() }}</td>
                                    <td>{{ $confession->comments->count() }}</td>
                                    <td>{{ $confession->likes->count() }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Release pengakuan yang lagi kamu handle."
                                                    href="#" class="btn btn-secondary px-2 pt-2"
                                                    data-confirm-confession-release="true"
                                                    data-unique="{{ base64_encode($confession->slug) }}">
                                                    <span data-confirm-confession-release="true"
                                                        data-unique="{{ base64_encode($confession->slug) }}"
                                                        class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Close pengakuan yang lagi kamu handle."
                                                    href="#" class="btn btn-danger px-2 pt-2"
                                                    data-confirm-confession-close="true"
                                                    data-unique="{{ base64_encode($confession->slug) }}">
                                                    <span data-confirm-confession-close="true"
                                                        data-unique="{{ base64_encode($confession->slug) }}"
                                                        class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Rincian dari suatu pengakuan."
                                                    href="/dashboard/confessions/{{ $confession->slug }}/responses/create"
                                                    class="btn btn-info px-2 pt-2">
                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <p class="text-center mt-3">Tidak ada pengakuan :(</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Unprocessed Confessions --}}
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between" style="row-gap: 1rem;">
                        <h3>Unprocessed Confessions</h3>

                        <div class="dropdown dropdown-color-icon mb-3 d-flex justify-content-start">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="export"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fa-fw select-all fas me-1"></span> Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="export">
                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="unprocessed-confessions">
                                    <input type="hidden" name="type" value="XLSX">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all far text-light"></span> Excel
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="unprocessed-confessions">
                                    <input type="hidden" name="type" value="CSV">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all fas text-light"></span> CSV
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="unprocessed-confessions">
                                    <input type="hidden" name="type" value="HTML">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all fab text-light"></span> HTML
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="unprocessed-confessions">
                                    <input type="hidden" name="type" value="MPDF">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all far text-light"></span> PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Kepemilikan</th>
                                <th>Kategori</th>
                                <th>Tanggapan</th>
                                <th>Komentar</th>
                                <th>Suka</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($unprocessedConfessions as $confession)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $confession->title }}</td>
                                    <td>{{ $confession->student->user->full_name }}</td>
                                    <td>{{ $confession->category->category_name }}</td>
                                    <td>{{ $confession->responses->count() }}</td>
                                    <td>{{ $confession->comments->count() }}</td>
                                    <td>{{ $confession->likes->count() }}</td>
                                    <td>
                                        @if ($confession->status == 'unprocess')
                                            <span class="badge bg-light-danger">
                                                Belum diproses
                                            </span>
                                        @elseif ($confession->status == 'process')
                                            <span class="badge bg-light-info">
                                                Sedang diproses
                                            </span>
                                        @elseif ($confession->status == 'release')
                                            <span class="badge bg-light">
                                                Release
                                            </span>
                                        @elseif ($confession->status == 'close')
                                            <span class="badge bg-light-success">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip" data-bs-original-title="Pick pengakuan ini."
                                                    href="#" class="btn btn-success px-2 pt-2"
                                                    data-confirm-confession-pick="true"
                                                    data-unique="{{ base64_encode($confession->slug) }}">
                                                    <span data-confirm-confession-pick="true"
                                                        data-unique="{{ base64_encode($confession->slug) }}"
                                                        class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Rincian dari suatu pengakuan."
                                                    href="/dashboard/confessions/{{ $confession->slug }}/responses/create"
                                                    class="btn btn-info px-2 pt-2">
                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <p class="text-center mt-3">Tidak ada pengakuan :(</p>
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

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- SweetAlert --}}
    @include('sweetalert::alert')
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/confession/confession.js'])
    {{-- Simple DataTable --}}
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    @vite(['resources/js/simple-datatable/confession/confession.js'])
    @vite(['resources/js/simple-datatable/officer/confessions/your-assigned-confession.js'])
    @vite(['resources/js/simple-datatable/officer/confessions/unprocessed-confession.js'])
@endsection
