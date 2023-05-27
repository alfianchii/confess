@extends('dashboard.layouts.main')

@section('links')
    {{-- Filepond: image auto crop --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}" />
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Pengaturan Website</h2>
                    <p class="text-subtitle text-muted">
                        Ubah informasi website sesuka kamu.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a data-bs-toggle="tooltip" data-bs-original-title="Kembali ke halaman sebelumnya."
                            href="{{ $previousUrl }}" class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
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
                                Website
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 order-md-3">
                    @if (session()->has('error'))
                        <div class="alert bg alert-dismissible show fade text-white mb-4">
                            {{ session('error') }}
                            <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @elseif (session()->has('success'))
                        <div class="alert bg bg-success alert-dismissible show fade text-white mb-4">
                            {{ session('success') }}
                            <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                    @endif
                </div>
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Settings</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/dashboard/website" method="POST"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf

                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('WEB_TITLE') is-invalid @enderror">
                                                <label for="WEB_TITLE" class="form-label">Judul Website</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2" placeholder="Confess"
                                                        id="WEB_TITLE" name="WEB_TITLE"
                                                        value="{{ old('WEB_TITLE', config('web_config')['WEB_TITLE']) }}"
                                                        maxlength="30" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-globe py-2"></i>
                                                    </div>
                                                    @error('WEB_TITLE')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('HERO_TEXT_HEADER') is-invalid @enderror">
                                                <label for="HERO_TEXT_HEADER" class="form-label">Hero Text Title</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="Sistem Pengaduan Online SMKN 4 Kota Tangerang"
                                                        id="HERO_TEXT_HEADER" name="HERO_TEXT_HEADER"
                                                        value="{{ old('HERO_TEXT_HEADER', config('web_config')['HERO_TEXT_HEADER']) }}"
                                                        maxlength="125" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-chat-left-text py-2"></i>
                                                    </div>
                                                    @error('HERO_TEXT_HEADER')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('HERO_TEXT_DESCRIPTION') is-invalid @enderror">
                                                <label for="HERO_TEXT_DESCRIPTION" class="form-label">Hero Text
                                                    Description</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="Sampaikan laporan, kritik, atau saran kamu di website ini~"
                                                        id="HERO_TEXT_DESCRIPTION" name="HERO_TEXT_DESCRIPTION"
                                                        value="{{ old('HERO_TEXT_DESCRIPTION', config('web_config')['HERO_TEXT_DESCRIPTION']) }}"
                                                        maxlength="255" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-chat-left-quote py-2"></i>
                                                    </div>
                                                    @error('HERO_TEXT_DESCRIPTION')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('WEB_LOCATION') is-invalid @enderror">
                                                <label for="WEB_LOCATION" class="form-label">Google Maps</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder='<iframe src="..." width="..." height="..."></iframe>'
                                                        id="WEB_LOCATION" name="WEB_LOCATION"
                                                        value="{{ old('WEB_LOCATION', config('web_config')['WEB_LOCATION']) }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-chat-left-quote py-2"></i>
                                                    </div>
                                                    @error('WEB_LOCATION')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('FOOTER_TEXT_DASHBOARD') is-invalid @enderror">
                                                <label for="FOOTER_TEXT_DASHBOARD" class="form-label">Footer Text
                                                    (Dashboard)</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder='SMK Negeri 4 Tangerang' id="FOOTER_TEXT_DASHBOARD"
                                                        name="FOOTER_TEXT_DASHBOARD"
                                                        value="{{ old('FOOTER_TEXT_DASHBOARD', config('web_config')['FOOTER_TEXT_DASHBOARD']) }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-chat-left-quote py-2"></i>
                                                    </div>
                                                    @error('FOOTER_TEXT_DASHBOARD')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="form-group">
                                                <label for="WEB_LOGO_WHITE" class="form-label">Logo Website
                                                    (Homepage)</label>
                                                <div class="position-relative">
                                                    <input type="hidden" name="OLD_WEB_LOGO_WHITE"
                                                        value="{{ config('web_config')['WEB_LOGO_WHITE'] }}">

                                                    <!-- Image preview -->
                                                    {{-- If WEB_LOGO_WHITE didn't contains "/" --}}
                                                    @if (strpos(config('web_config')['WEB_LOGO_WHITE'], '/') === false)
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('images/' . config('web_config')['WEB_LOGO_WHITE']) }}"
                                                            alt="Logo Website">
                                                    @else
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('storage/' . config('web_config')['WEB_LOGO_WHITE']) }}"
                                                            alt="Logo Website">
                                                    @endif

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-preview-filepond"
                                                        name="WEB_LOGO_WHITE" />

                                                    @error('WEB_LOGO_WHITE')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="form-group ">
                                                <label for="WEB_LOGO" class="form-label">Logo Website
                                                    (Dashboard)</label>
                                                <div class="position-relative">
                                                    <input type="hidden" name="OLD_WEB_LOGO"
                                                        value="{{ config('web_config')['WEB_LOGO'] }}">

                                                    <!-- Image preview -->
                                                    {{-- If WEB_LOGO didn't contains "/" --}}
                                                    @if (strpos(config('web_config')['WEB_LOGO'], '/') === false)
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('images/' . config('web_config')['WEB_LOGO']) }}"
                                                            alt="Logo Website">
                                                    @else
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('storage/' . config('web_config')['WEB_LOGO']) }}"
                                                            alt="Logo Website">
                                                    @endif

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-preview-filepond"
                                                        name="WEB_LOGO" />

                                                    @error('WEB_LOGO')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="form-group ">
                                                <label for="WEB_FAVICON" class="form-label">Favicon Website</label>
                                                <div class="position-relative">
                                                    <input type="hidden" name="OLD_WEB_FAVICON"
                                                        value="{{ config('web_config')['WEB_FAVICON'] }}">

                                                    <!-- Image preview -->
                                                    {{-- If WEB_FAVICON didn't contains "/" --}}
                                                    @if (strpos(config('web_config')['WEB_FAVICON'], '/') === false)
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('images/' . config('web_config')['WEB_FAVICON']) }}"
                                                            alt="Favicon Website">
                                                    @else
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('storage/' . config('web_config')['WEB_FAVICON']) }}"
                                                            alt="Favicon Website">
                                                    @endif

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-preview-filepond"
                                                        name="WEB_FAVICON" />

                                                    @error('WEB_FAVICON')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="form-group ">
                                                <label for="FOOTER_IMAGE" class="form-label">Footer Website
                                                    (Homepage)</label>
                                                <div class="position-relative">
                                                    <input type="hidden" name="OLD_FOOTER_IMAGE"
                                                        value="{{ config('web_config')['FOOTER_IMAGE'] }}">

                                                    <!-- Image preview -->
                                                    {{-- If FOOTER_IMAGE didn't contains "/" --}}
                                                    @if (strpos(config('web_config')['FOOTER_IMAGE'], '/') === false)
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('images/' . config('web_config')['FOOTER_IMAGE']) }}"
                                                            alt="Footer Website">
                                                    @else
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('storage/' . config('web_config')['FOOTER_IMAGE']) }}"
                                                            alt="Footer Website">
                                                    @endif

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-preview-filepond"
                                                        name="FOOTER_IMAGE" />

                                                    @error('FOOTER_IMAGE')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="form-group ">
                                                <label for="FOOTER_IMAGE_DASHBOARD" class="form-label">Footer Website
                                                    (Dashboard)</label>
                                                <div class="position-relative">
                                                    <input type="hidden" name="OLD_FOOTER_IMAGE_DASHBOARD"
                                                        value="{{ config('web_config')['FOOTER_IMAGE_DASHBOARD'] }}">

                                                    <!-- Image preview -->
                                                    {{-- If FOOTER_IMAGE_DASHBOARD didn't contains "/" --}}
                                                    @if (strpos(config('web_config')['FOOTER_IMAGE_DASHBOARD'], '/') === false)
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('images/' . config('web_config')['FOOTER_IMAGE_DASHBOARD']) }}"
                                                            alt="Footer Website">
                                                    @else
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('storage/' . config('web_config')['FOOTER_IMAGE_DASHBOARD']) }}"
                                                            alt="Footer Website">
                                                    @endif

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-preview-filepond"
                                                        name="FOOTER_IMAGE_DASHBOARD" />

                                                    @error('FOOTER_IMAGE_DASHBOARD')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mt-3 d-flex justify-content-start">
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

@section('scripts')
    {{-- Filepond: image auto crop --}}
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
    <script src="{{ asset('assets/extensions/filepond/filepond.js') }}"></script>
    @vite(['resources/js/uploader/image.js'])
@endsection
