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
                    <h2>Registrasi Pengguna</h2>
                    <p class="text-subtitle text-muted">
                        Daftarkan pengguna untuk melakukan sesuatu di {{ config('web_config')['WEB_TITLE'] }}.
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
                            <li class="breadcrumb-item">
                                <a href="/dashboard/users">Pengguna</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Registrasi
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
                            <h3 class="card-title mb-0">Pengguna</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/dashboard/users" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('name') is-invalid @enderror">
                                                <label for="name" class="form-label">Nama</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="e.g. Muhammad Alfian" id="name" name="name"
                                                        value="{{ old('name') }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person py-2"></i>
                                                    </div>
                                                    @error('name')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('nik') is-invalid @enderror">
                                                <label for="nik" class="form-label">NIK</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="e.g. 1050241708900001" id="nik" name="nik"
                                                        value="{{ old('nik') }}" maxlength="16" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person-vcard py-2"></i>
                                                    </div>
                                                    @error('nik')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('username') is-invalid @enderror">
                                                <label for="username" class="form-label">Username</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2" placeholder="alfianchii"
                                                        id="username" name="username" value="{{ old('username') }}"
                                                        maxlength="255" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-at py-2"></i>
                                                    </div>
                                                    @error('username')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('email') is-invalid @enderror">
                                                <label for="email" class="form-label">Email</label>
                                                <div class="position-relative">
                                                    <input type="email" class="form-control py-2"
                                                        placeholder="e.g. alfian.dev@gmail.com" id="email"
                                                        name="email" value="{{ old('email') }}" maxlength="255" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope-paper py-2"></i>
                                                    </div>
                                                    @error('email')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('password') is-invalid @enderror">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control py-2"
                                                        placeholder="e.g. 4kuBu7uhM3dk1t" id="password" name="password"
                                                        maxlength="255" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-key py-2"></i>
                                                    </div>
                                                    @error('password')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('password_confirmation') is-invalid @enderror">
                                                <label for="password_confirmation" class="form-label">Konfirmasi
                                                    Password</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control py-2"
                                                        placeholder="e.g. 4kuBu7uhM3dk1t" id="password_confirmation"
                                                        name="password_confirmation" maxlength="255" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-key-fill py-2"></i>
                                                    </div>
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group mandatory @error('gender') text-danger is-invalid @enderror">
                                                <fieldset>
                                                    <label class="form-label">
                                                        Jenis Kelamin
                                                    </label>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="gender"
                                                                id="gender-L" value="L"
                                                                @if (old('gender') == 'L') checked @endif />
                                                            <label class="form-check-label form-label" for="gender-L">
                                                                Laki-laki
                                                            </label>
                                                        </div>
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="gender"
                                                                id="gender-P" value="P"
                                                                @if (old('gender') == 'p') checked @endif />
                                                            <label class="form-check-label form-label" for="gender-P">
                                                                Perempuan
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                @error('gender')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group mandatory @error('level') text-danger is-invalid @enderror">
                                                <fieldset>
                                                    <label class="form-label">
                                                        Status
                                                    </label>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="level"
                                                                id="level-student" value="student"
                                                                @if (old('level') == 'student') checked @endif />
                                                            <label data-bs-toggle="tooltip"
                                                                data-bs-original-title="Status pengguna sebagai siswa."
                                                                class="form-check-label form-label" for="level-student">
                                                                Student
                                                            </label>
                                                        </div>
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="level"
                                                                id="level-officer" value="officer"
                                                                @if (old('level') == 'officer') checked @endif />
                                                            <label data-bs-toggle="tooltip"
                                                                data-bs-original-title="Status pengguna sebagai pegawai."
                                                                class="form-check-label form-label" for="level-officer">
                                                                Officer
                                                            </label>
                                                        </div>
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="level"
                                                                id="level-admin" value="admin"
                                                                @if (old('level') == 'admin') checked @endif />
                                                            <label data-bs-toggle="tooltip"
                                                                data-bs-original-title="Status pengguna sebagai admin."
                                                                class="form-check-label form-label" for="level-admin">
                                                                Admin
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                @error('level')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group ">
                                                <div class="position-relative">
                                                    <label for="image" class="form-label">Foto</label>

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" class="image-crop-filepond" name="image" />

                                                    @error('image')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
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
