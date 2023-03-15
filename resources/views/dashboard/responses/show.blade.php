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
                        Detail dari tanggapan yang kamu berikan.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="/dashboard/responses" class="btn btn-secondary me-1"><span
                                data-feather="arrow-left"></span>
                            Kembali</a>
                        <a href="/dashboard/responses/{{ $response->id }}/edit" class="badge bg-warning me-1"><span
                                data-feather="edit"></span> Edit</a>
                        <a href="#" class="badge bg-danger border-0 delete-record me-1"
                            data-slug="{{ $response->id }}"><span data-feather="x-circle" class="delete-record"
                                data-slug="{{ $response->id }}"></span> Hapus</a>
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard/responses">Responses</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Detail
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
                    <h3 class="card-title">Tanggapan</h3>
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
                                <span class="fw-bold">Judul keluhan:</span> {{ $response->complaint->title }}
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
