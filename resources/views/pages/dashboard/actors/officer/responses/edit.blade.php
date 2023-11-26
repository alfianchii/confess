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
                    <h2>Sunting Tanggapan</h2>
                    <p class="text-subtitle text-muted">
                        Lakukan penyuntingan terhadap suatu tanggapan.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="{{ back()->getTargetUrl() }}" data-bs-toggle="tooltip"
                            data-bs-original-title="Kembali ke halaman sebelumnya."
                            class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                            Kembali
                        </a>
                        <a data-bs-toggle="tooltip" data-bs-original-title="Unsend tanggapan yang sudah kamu berikan."
                            class="btn btn-danger px-2 pt-2" data-confirm-confession-response-destroy="true"
                            data-unique="{{ base64_encode($response->id_confession_response) }}"
                            data-redirect="{{ base64_encode($confession->slug) }}">
                            <span data-confirm-confession-response-destroy="true"
                                data-redirect="{{ base64_encode($confession->slug) }}"
                                data-unique="{{ base64_encode($response->id_confession_response) }}"
                                class="fa-fw fa-lg select-all fas"></span>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard/confessions/responses">Tanggapan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Sunting
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title d-inline-block">Tanggapan</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form"
                                    action="/dashboard/responses/{{ base64_encode($response->id_confession_response) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf

                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div
                                                class="form-group mandatory @error('response'){{ 'is-invalid' }}@enderror">
                                                <div class="position-relative">
                                                    <label for="response" class="form-label">Isi Tanggapan</label>

                                                    <input id="response" name="response"
                                                        value="{{ old('response') ?? $response->response }}"
                                                        type="hidden">
                                                    <div id="editor">
                                                        {!! old('response') ?? $response->response !!}
                                                    </div>

                                                    @error('response')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <div class="form-group @error('attachment_file'){{ 'is-invalid' }}@enderror">
                                                <label for="attachment_file" class="form-label">File Pendukung</label>

                                                <!-- File preview -->
                                                <input type="file" id="attachment_file" class="basic-file-filepond"
                                                    name="attachment_file" />

                                                @error('attachment_file')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    @if ($response->attachment_file)
                                        <div class="mb-4">
                                            <div class="attachment-file">
                                                <a class="btn btn-danger px-2 pt-2 position-absolute"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="Unsend file pendukung yang sudah kamu berikan."
                                                    data-confirm-confession-response-attachment-destroy="true"
                                                    data-unique="{{ base64_encode($response->id_confession_response) }}"
                                                    data-redirect="{{ base64_encode($confession->slug) }}">
                                                    <span data-confirm-confession-response-attachment-destroy="true"
                                                        data-unique="{{ base64_encode($response->id_confession_response) }}"
                                                        data-redirect="{{ base64_encode($confession->slug) }}"
                                                        class="fa-fw fa-lg select-all fas"></span>
                                                </a>

                                                <div class="attachment-file-body text-center">
                                                    <i class="far fa-file-alt icon-9x"></i>
                                                </div>
                                                <div class="attachment-file-footer">
                                                    <a href="{{ asset("storage/$response->attachment_file") }}"
                                                        target="_blank" class="btn btn-primary">
                                                        <i class="far fas fa-box-open me-2"></i> Open it up!
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-12 mt-2 d-flex justify-content-start">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- If alert error exists --}}
    @if (session()->has('alert') &&
            array_key_exists('config', session('alert')) &&
            json_decode(session('alert')['config'], true)['icon'] === 'error')
        {{-- Unset the "alert" session variable --}}
        {{ Session::forget('alert') }}
    @endif

    {{-- Filepond: file preview --}}
    <script src="{{ asset('assets/extensions/filepond/filepond.js') }}"></script>
    <script
        src="{{ asset('assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
    <script
        src="{{ asset('assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}">
    </script>
    @vite(['resources/js/filepond/basic-file.js'])
    {{-- Quill --}}
    @vite(['resources/js/quill/confession/response/response.js'])
    <script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
    {{-- SweetAlert --}}
    @vite(['resources/js/sweetalert/confession/response/response.js'])
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
