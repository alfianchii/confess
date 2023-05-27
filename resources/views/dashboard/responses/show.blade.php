@extends('dashboard.layouts.main')

@section('links')
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Tentang Tanggapan</h2>
                    <p class="text-subtitle text-muted">
                        Rincian dari tanggapan yang kamu berikan.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a data-bs-toggle="tooltip" data-bs-original-title="Kembali ke halaman sebelumnya."
                            href="{{ $previousUrl }}" class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                        </a>
                        @if ($response->complaint->status != 2)
                            <a data-bs-toggle="tooltip" data-bs-original-title="Sunting tanggapan milik kamu."
                                href="/dashboard/responses/{{ $response->id }}/edit" class="btn btn-warning px-2 pt-2 me-1">
                                <span class="fa-fw fa-lg select-all fas"></span>
                            </a>
                            <a data-bs-toggle="tooltip" data-bs-original-title="Hapus tanggapan yang sudah kamu berikan."
                                href="#" class="btn btn-danger px-2 pt-2 delete-record me-1"
                                data-slug="{{ $response->id }}">
                                <span data-slug="{{ $response->id }}"
                                    class="delete-record fa-fw fa-lg select-all fas"></span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard/responses">Tanggapan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Rincian
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            {{-- Complaint --}}
            <div class="card mb-5">
                <div class="card-header">
                    <h3 class="card-title d-inline-block">Tanggapan</h3> <a
                        href="/dashboard/responses/create/{{ $response->complaint->slug }}"><small>({{ $response->complaint->privacy }})</small></a>
                    <p class="text-subtitle text-muted">
                        {{ $response->created_at->diffForHumans() }}
                    </p>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 col-md-6">
                            <p>
                                <span class="fw-bold">Menanggapi keluhan milik:</span>
                                {{ $response->complaint->student->user->name }}
                            </p>
                        </div>
                        <div class="col-12 col-md-6">
                            <p>
                                <span class="fw-bold">Tempat kejadian:</span>
                                @if ($response->complaint->place == 'in')
                                    Dalam Sekolah
                                @elseif ($response->complaint->place == 'out')
                                    Luar Sekolah
                                @endif
                            </p>
                        </div>
                        <div class="col-12 col-md-6">
                            <p>
                                <span class="fw-bold">Judul keluhan:</span>
                                <a href="/dashboard/responses/create/{{ $response->complaint->slug }}">
                                    {{ $response->complaint->title }}
                                </a>
                            </p>
                        </div>
                        <div class="col-12 col-md-6">
                            <p>
                                <span class="fw-bold">Kategori:</span> {{ $response->complaint->category->name }}
                            </p>
                        </div>
                        <div class="col-12">
                            <p>
                                <span class="fw-bold me-1">Status:</span>
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
                            </p>
                        </div>
                    </div>
                    <hr>

                    <p>
                        {!! $response->body !!}
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    {{-- SweetAlert --}}
    @vite(['resources/js/sweetalert/swalSingle.js'])
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
