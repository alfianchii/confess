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
                    <h3>All of Responses</h3>
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
                                            {{-- --------------------------------- Rules --}}
                                            @if (
                                                $response->id_user === $userData->id_user &&
                                                    ($response->confession->status === 'unprocess' || $response->confession->status === 'process'))
                                                <div class="me-2">
                                                    <a data-bs-original-title="Sunting tanggapan milik kamu."
                                                        data-bs-toggle="tooltip"
                                                        href="/dashboard/responses/{{ base64_encode($response->id_confession_response) }}/edit"
                                                        class="btn btn-warning px-2 pt-2">
                                                        <span class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Unsend tanggapan yang sudah kamu berikan."
                                                        class="btn btn-danger px-2 pt-2"
                                                        data-confirm-confession-response-destroy="true"
                                                        data-unique="{{ base64_encode($response->id_confession_response) }}"
                                                        data-redirect="{{ base64_encode($response->confession->slug) }}">
                                                        <span data-confirm-confession-response-destroy="true"
                                                            data-redirect="{{ base64_encode($response->confession->slug) }}"
                                                            data-unique="{{ base64_encode($response->id_confession_response) }}"
                                                            class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                            @endif

                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Rincian dari suatu pengakuan."
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
                                        <p class="text-center mt-3">Tidak ada tanggapan :(</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Your Responses --}}
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3>Your Response(s)</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggapan</th>
                                <th>File pendukung</th>
                                <th>Sunting</th>
                                <th>Tanggal</th>
                                <th>Status Pengakuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($yourResponses as $response)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
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
                                            {{-- --------------------------------- Rules --}}
                                            @if ($response->confession->status === 'unprocess' || $response->confession->status === 'process')
                                                <div class="me-2">
                                                    <a data-bs-original-title="Sunting tanggapan milik kamu."
                                                        data-bs-toggle="tooltip"
                                                        href="/dashboard/responses/{{ base64_encode($response->id_confession_response) }}/edit"
                                                        class="btn btn-warning px-2 pt-2">
                                                        <span class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Unsend tanggapan yang sudah kamu berikan."
                                                        class="btn btn-danger px-2 pt-2"
                                                        data-confirm-confession-response-destroy="true"
                                                        data-unique="{{ base64_encode($response->id_confession_response) }}"
                                                        data-redirect="{{ base64_encode($response->confession->slug) }}">
                                                        <span data-confirm-confession-response-destroy="true"
                                                            data-redirect="{{ base64_encode($response->confession->slug) }}"
                                                            data-unique="{{ base64_encode($response->id_confession_response) }}"
                                                            class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                            @endif

                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Rincian dari suatu pengakuan."
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
                                    <td colspan="7">
                                        <p class="text-center mt-3">Tidak ada tanggapan :(</p>
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
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/confession/response/response.js'])
    {{-- Simple DataTable --}}
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    @vite(['resources/js/simple-datatable/confession/response/response.js'])
    @vite(['resources/js/simple-datatable/officer/responses/all-responses.js'])
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
@endsection
