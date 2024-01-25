@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />
    {{-- File preview --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Panduan Aplikasi</h2>
                    <p class="text-subtitle text-muted">
                        Mohon untuk membaca petunjuk aplikasi dengan seksama agar dapat memahami cara kerja aplikasi ini,
                        ya.
                    </p>
                    <hr>

                    @can('admin')
                        <div class="mb-4">
                            <a href="/dashboard/setting/guides/{{ $guide->slug }}/edit" data-bs-toggle="tooltip"
                                data-bs-original-title="Lakukan penyuntingan terhadap panduan {{ $guide->nav_title }}."
                                class="btn btn-warning px-2 pt-2 me-1 text-white">
                                <span class="fa-fw fa-lg select-all fas"></span>
                                Sunting
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            {!! $guideBreadcrumbsHTML($guide) !!}
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title d-inline-block">{{ $guide->title }}</h3>
                </div>
                <div class="card-body">
                    <div class="me-4">
                        <p>
                            <span class="fw-bold">Update terakhir:</span>
                            {{ $guide->updated_at->format('d M Y, \a\t H:i') }}
                        </p>
                        <p>
                            <span class="fw-bold">Waktu membaca: </span> {{ $secondToMinute($guide->reading_time) }} menit
                        </p>
                    </div>

                    <hr>

                    <p>
                        {!! $guide->body !!}
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- SweetAlert --}}
    @include('sweetalert::alert')
@endsection
