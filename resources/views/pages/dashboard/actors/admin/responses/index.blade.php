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
                    <h2>Semua Tanggapan</h2>
                    <p class="text-subtitle text-muted">
                        Keseluruhan data dari tanggapan.
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
                                Tanggapan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        {{-- All of Responses --}}
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between" style="row-gap: 1rem;">
                        <h3>All of Responses</h3>

                        <div class="dropdown dropdown-color-icon mb-3 d-flex justify-content-start">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="export"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fa-fw select-all fas me-1"></span> Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="export">
                                <form action="/dashboard/confessions/responses/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="all-of-responses">
                                    <input type="hidden" name="type" value="XLSX">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all far text-light"></span> Excel
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/responses/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="all-of-responses">
                                    <input type="hidden" name="type" value="CSV">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all fas text-light"></span> CSV
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/responses/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="all-of-responses">
                                    <input type="hidden" name="type" value="HTML">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all fab text-light"></span> HTML
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/responses/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="all-of-responses">
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
                                <th>Kepemilikan</th>
                                <th>Tanggapan</th>
                                <th>File pendukung</th>
                                <th>Sunting</th>
                                <th>Tanggal</th>
                                <th>Status Pengakuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($allResponses as $response)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $response->user->full_name }}</td>
                                    <td>{!! $response->response !!}</td>
                                    <td>
                                        @if ($response->attachment_file)
                                            <a href="{{ asset("storage/$response->attachment_file") }}" target="_blank">
                                                <span class="badge bg-light-warning">Ya</span>
                                            </a>
                                        @else
                                            <span class="badge bg-light-dark">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($response->updated_by)
                                            <span class="badge bg-light-warning">Ya</span>
                                        @else
                                            <span class="badge bg-light-dark">Tidak</span>
                                        @endif
                                    </td>
                                    <td>{{ $response->created_at->format('d F Y, \a\t H:i') }}</td>
                                    <td>
                                        @if ($response->confession->status == 'unprocess')
                                            <span class="badge bg-light-danger">
                                                Belum diproses
                                            </span>
                                        @elseif ($response->confession->status == 'process')
                                            <span class="badge bg-light-info">
                                                Sedang diproses
                                            </span>
                                        @elseif ($response->confession->status == 'release')
                                            <span class="badge bg-light">
                                                Release
                                            </span>
                                        @elseif ($response->confession->status == 'close')
                                            <span class="badge bg-light-success">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip" data-bs-original-title="Rincian dari pengakuan."
                                                    href="/dashboard/confessions/{{ $response->confession->slug }}/responses/create?response={{ base64_encode($response->id_confession_response) }}&page={{ $response->page }}"
                                                    class="btn btn-info px-2 pt-2">
                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
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
    @vite(['resources/js/sweetalert/confession/response/response.js'])
    {{-- Simple DataTable --}}
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    @vite(['resources/js/simple-datatable/confession/response/response.js'])
    @vite(['resources/js/simple-datatable/officer/responses/all-responses.js'])
@endsection
