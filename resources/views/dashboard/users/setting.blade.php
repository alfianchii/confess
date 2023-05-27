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
                    <h2>Setting</h2>
                    <p class="text-subtitle text-muted">
                        Lakukan set-up pada beberapa data yang kamu miliki.
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
                                <a href="/dashboard/user/account/profile">Akun</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Pengaturan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card mb-5">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h3 class="card-title">Pengguna</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form" action="/dashboard/user/account/setting/{{ $user->username }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-12 mb-1">
                                <div class="form-group has-icon-left mandatory @error('name') is-invalid @enderror">
                                    <label for="name" class="form-label">Nama</label>
                                    <div class="position-relative">
                                        <input @if ($user->level != 'admin') @readonly(true) @endif type="text"
                                            class="form-control py-2" placeholder="e.g. Muhammad Alfian" id="name"
                                            name="name" value="{{ old('name', $user->name) }}" />
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
                                <div class="form-group has-icon-left mandatory @error('nik') is-invalid @enderror">
                                    <label for="nik" class="form-label">NIK</label>
                                    <div class="position-relative">
                                        <input @if ($user->level != 'admin') @readonly(true) @endif type="text"
                                            class="form-control py-2" placeholder="e.g. 1050241708900001" id="nik"
                                            name="nik" value="{{ old('nik', $user->nik) }}" maxlength="16" />
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
                                <div class="form-group has-icon-left mandatory @error('username') is-invalid @enderror">
                                    <label for="username" class="form-label">Username</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control py-2" placeholder="alfianchii"
                                            id="username" name="username" value="{{ old('username', $user->username) }}"
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
                                <div class="form-group has-icon-left mandatory @error('email') is-invalid @enderror">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="position-relative">
                                        <input type="email" class="form-control py-2"
                                            placeholder="e.g. alfian.dev@gmail.com" id="email" name="email"
                                            value="{{ old('email', $user->email) }}" maxlength="255" />
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
                        </div>
                        <div class="row">
                            <div class="col-12 mb-1">
                                @if ($user->level == 'student')
                                    <div class="form-group has-icon-left mandatory @error('nisn') is-invalid @enderror">
                                        <label for="nisn" class="form-label">NISN</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control py-2" placeholder="e.g. 1050241708"
                                                id="nisn" name="nisn"
                                                value="{{ old('nisn', $user->student->nisn) }}" maxlength="10" />
                                            <div class="form-control-icon">
                                                <i class="bi bi-person-vcard py-2"></i>
                                            </div>
                                            @error('nisn')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group has-icon-left mandatory @error('nip') is-invalid @enderror">
                                        <label for="nip" class="form-label">NIP</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control py-2"
                                                placeholder="e.g. 105024170890000112" id="nip" name="nip"
                                                value="{{ old('nip', $user->officer->nip) }}" maxlength="18" />
                                            <div class="form-control-icon">
                                                <i class="bi bi-person-vcard py-2"></i>
                                            </div>
                                            @error('nip')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-1">
                                <div class="form-group ">
                                    <label for="image" class="form-label">Foto</label>
                                    <div class="position-relative">
                                        <input type="hidden" name="oldImage" value="{{ $user->image }}">

                                        <!-- Image preview -->
                                        @if ($user->image)
                                            <img src="{{ asset("storage/$user->image") }}"
                                                class="img-fluid bg-nav box-gradient rounded mb-3 col-sm-5">
                                        @endif

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
