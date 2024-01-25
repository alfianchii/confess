@extends('pages.auth.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="d-flex flex-column mx-auto justify-content-center align-items-center w-100">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center align-items-center">
                    <a href="/" class="d-block mt-5 mb-4">
                        {{-- Default --}}
                        @if (File::exists(public_path('images/' . config('web_config')['IMAGE_WEB_FAVICON'])))
                            <img src="{{ asset('images/' . config('web_config')['IMAGE_WEB_FAVICON']) }}"
                                alt="Logo {{ config('web_config')['TEXT_WEB_TITLE'] }}">
                        @else
                            <img src="{{ asset('storage/' . config('web_config')['IMAGE_WEB_FAVICON']) }}"
                                alt="Logo {{ config('web_config')['TEXT_WEB_TITLE'] }}">
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <div class="row w-100 position-relative">
            <div class="col-md-3">
                <img class="position-absolute login-1" width="600"
                    src="{{ asset('images/illustrations/login-visual-1.svg') }}" alt="Visual">
            </div>

            <div class="col-11 col-md-6 col-lg-5 mx-auto">
                <div class="card shadow-lg" style="border-top: 2px solid #6777ef;">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="mb-4">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                                    </ol>
                                </nav>
                            </div>

                            <div class="pb-4">
                                <h4 class="card-title">Login</h4>
                                <p class="card-text">
                                    Masukkan username dan password kamu.
                                </p>
                            </div>

                            {{-- Session --}}
                            @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <small class="fs-6 text-white">
                                        <i class="bi bi-exclamation-triangle-fill text-white me-2 align-text-bottom"></i>
                                        {{ session('error') }}
                                    </small>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @elseif (session()->has('success'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <small class="fs-6 text-white">
                                        <i class="bi bi-patch-check text-white me-2 align-text-bottom"></i>
                                        {{ session('success') }}
                                    </small>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form class="form" action="/login" method="post">
                                @csrf

                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text"
                                            class="form-control @error('username'){{ 'is-invalid' }}@enderror"
                                            id="username" name="username" value="{{ old('username') }}"
                                            placeholder="e.g. alfianchii" autofocus />

                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="d-flex flex-row-reverse align-items-center" id="wrapper">
                                            <input type="password"
                                                class="form-control @error('password'){{ 'is-invalid' }}@enderror"
                                                id="password" name="password" placeholder="e.g. 4kuBu7uhM3dk1t" />
                                            <button type="button" class="btn bg-transparent show-password" id="show-btn">
                                                <i class="bi bi-eye-slash-fill"></i>
                                            </button>
                                        </div>

                                        @error('password')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-actions d-flex justify-content-end mt-4">
                                    <button type="submit" class="w-100 btn-primary btn text-white p-2">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <img class="position-absolute login-2" width="600"
                    src="{{ asset('images/illustrations/login-visual-2.svg') }}" alt="Visual">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="text-center my-4 px-5">
                    <small class="text-muted fw-light">Belum memiliki akun? Coba tanyakan kepada pihak
                        sekolah, ya.</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @include('pages.auth.layouts.footer')
            </div>
        </div>
    </div>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
@endsection
