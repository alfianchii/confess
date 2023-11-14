@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- Filepond: image auto crop --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}" />
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Pengaturan Website</h2>
                    <p class="text-subtitle text-muted">
                        Ubah informasi website sesuka kamu :)
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="{{ back()->getTargetUrl() }}" data-bs-toggle="tooltip"
                            data-bs-original-title="Kembali ke halaman sebelumnya."
                            class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                            Kembali
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
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pengaturan</h3>
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
                                                class="form-group has-icon-left mandatory @error('TEXT_WEB_TITLE'){{ 'is-invalid' }}@enderror">
                                                <label for="TEXT_WEB_TITLE" class="form-label">Judul Website</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2" placeholder="Confess"
                                                        id="TEXT_WEB_TITLE" name="TEXT_WEB_TITLE"
                                                        value="{{ old('TEXT_WEB_TITLE', config('web_config')['TEXT_WEB_TITLE']) }}"
                                                        maxlength="30" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-globe py-2"></i>
                                                    </div>
                                                    @error('TEXT_WEB_TITLE')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('TEXT_HERO_HEADER'){{ 'is-invalid' }}@enderror">
                                                <label for="TEXT_HERO_HEADER" class="form-label">Hero Text Title</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="Sistem Pengakuan Online SMKN 4 Kota Tangerang"
                                                        id="TEXT_HERO_HEADER" name="TEXT_HERO_HEADER"
                                                        value="{{ old('TEXT_HERO_HEADER', config('web_config')['TEXT_HERO_HEADER']) }}"
                                                        maxlength="125" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-chat-left-text py-2"></i>
                                                    </div>
                                                    @error('TEXT_HERO_HEADER')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('TEXT_HERO_DESCRIPTION'){{ 'is-invalid' }}@enderror">
                                                <label for="TEXT_HERO_DESCRIPTION" class="form-label">Hero Text
                                                    Description</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="Sampaikan pengakuan kamu di website ini~"
                                                        id="TEXT_HERO_DESCRIPTION" name="TEXT_HERO_DESCRIPTION"
                                                        value="{{ old('TEXT_HERO_DESCRIPTION', config('web_config')['TEXT_HERO_DESCRIPTION']) }}"
                                                        maxlength="255" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-chat-left-quote py-2"></i>
                                                    </div>
                                                    @error('TEXT_HERO_DESCRIPTION')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('TEXT_WEB_LOCATION'){{ 'is-invalid' }}@enderror">
                                                <label for="TEXT_WEB_LOCATION" class="form-label">Google Maps</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder='<iframe src="..." width="..." height="..."></iframe>'
                                                        id="TEXT_WEB_LOCATION" name="TEXT_WEB_LOCATION"
                                                        value="{{ old('TEXT_WEB_LOCATION', config('web_config')['TEXT_WEB_LOCATION']) }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-chat-left-quote py-2"></i>
                                                    </div>
                                                    @error('TEXT_WEB_LOCATION')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('TEXT_FOOTER'){{ 'is-invalid' }}@enderror">
                                                <label for="TEXT_FOOTER" class="form-label">Footer Text
                                                    (Dashboard)</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder='SMK Negeri 4 Tangerang' id="TEXT_FOOTER"
                                                        name="TEXT_FOOTER"
                                                        value="{{ old('TEXT_FOOTER', config('web_config')['TEXT_FOOTER']) }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-chat-left-quote py-2"></i>
                                                    </div>
                                                    @error('TEXT_FOOTER')
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
                                                <label for="IMAGE_WEB_LOGO_WHITE" class="form-label">Logo Website
                                                    (Homepage)</label>
                                                <div class="position-relative">
                                                    <!-- Image preview -->
                                                    @if (File::exists(public_path('images/' . config('web_config')['IMAGE_WEB_LOGO_WHITE'])))
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('images/' . config('web_config')['IMAGE_WEB_LOGO_WHITE']) }}"
                                                            alt="Logo Website">
                                                    @else
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('storage/' . config('web_config')['IMAGE_WEB_LOGO_WHITE']) }}"
                                                            alt="Logo Website">
                                                    @endif

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-preview-filepond"
                                                        name="IMAGE_WEB_LOGO_WHITE" />

                                                    @error('IMAGE_WEB_LOGO_WHITE')
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
                                            <div class="form-group">
                                                <label for="IMAGE_WEB_LOGO" class="form-label">Logo Website
                                                    (Dashboard)</label>
                                                <div class="position-relative">
                                                    <!-- Image preview -->
                                                    @if (File::exists(public_path('images/' . config('web_config')['IMAGE_WEB_LOGO'])))
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('images/' . config('web_config')['IMAGE_WEB_LOGO']) }}"
                                                            alt="Logo Website">
                                                    @else
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('storage/' . config('web_config')['IMAGE_WEB_LOGO']) }}"
                                                            alt="Logo Website">
                                                    @endif

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-preview-filepond"
                                                        name="IMAGE_WEB_LOGO" />

                                                    @error('IMAGE_WEB_LOGO')
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
                                            <div class="form-group">
                                                <label for="IMAGE_WEB_FAVICON" class="form-label">Favicon Website</label>
                                                <div class="position-relative">
                                                    <!-- Image preview -->
                                                    @if (File::exists(public_path('images/' . config('web_config')['IMAGE_WEB_FAVICON'])))
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('images/' . config('web_config')['IMAGE_WEB_FAVICON']) }}"
                                                            alt="Favicon Website">
                                                    @else
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('storage/' . config('web_config')['IMAGE_WEB_FAVICON']) }}"
                                                            alt="Favicon Website">
                                                    @endif

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-preview-filepond"
                                                        name="IMAGE_WEB_FAVICON" />

                                                    @error('IMAGE_WEB_FAVICON')
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
                                            <div class="form-group">
                                                <label for="IMAGE_FOOTER" class="form-label">Footer Website
                                                    (Homepage)</label>
                                                <div class="position-relative">
                                                    <!-- Image preview -->
                                                    @if (File::exists(public_path('images/' . config('web_config')['IMAGE_FOOTER'])))
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('images/' . config('web_config')['IMAGE_FOOTER']) }}"
                                                            alt="Footer Website">
                                                    @else
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('storage/' . config('web_config')['IMAGE_FOOTER']) }}"
                                                            alt="Footer Website">
                                                    @endif

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-preview-filepond"
                                                        name="IMAGE_FOOTER" />

                                                    @error('IMAGE_FOOTER')
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
                                            <div class="form-group">
                                                <label for="IMAGE_FOOTER_DASHBOARD" class="form-label">Footer Website
                                                    (Dashboard)</label>
                                                <div class="position-relative">
                                                    <!-- Image preview -->
                                                    @if (File::exists(public_path('images/' . config('web_config')['IMAGE_FOOTER_DASHBOARD'])))
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('images/' . config('web_config')['IMAGE_FOOTER_DASHBOARD']) }}"
                                                            alt="Footer Website">
                                                    @else
                                                        <img class="img-fluid rounded mb-3 col-sm-5"
                                                            src="{{ asset('storage/' . config('web_config')['IMAGE_FOOTER_DASHBOARD']) }}"
                                                            alt="Footer Website">
                                                    @endif

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-preview-filepond"
                                                        name="IMAGE_FOOTER_DASHBOARD" />

                                                    @error('IMAGE_FOOTER_DASHBOARD')
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

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
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
    @vite(['resources/js/filepond/image-preview.js'])
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
@endsection
