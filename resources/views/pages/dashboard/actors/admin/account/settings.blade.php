@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- Filepond: image auto crop --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}" />
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Pengaturan</h2>
                    <p class="text-subtitle text-muted">
                        Lakukan set-up pada beberapa data akun yang kamu miliki.
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
                            <li class="breadcrumb-item">
                                <a href="/dashboard/users/account">Profil</a>
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
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h3 class="card-title">Pengguna</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form" action="/dashboard/users/account/settings/{{ $userData->username }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-12 mb-1">
                                <div
                                    class="form-group has-icon-left mandatory @error('full_name'){{ 'is-invalid' }}@enderror">
                                    <label for="full_name" class="form-label">Nama</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control py-2" placeholder="e.g. Muhammad Alfian"
                                            id="full_name" name="full_name"
                                            value="{{ old('full_name') ?? $userData->full_name }}" />
                                        <div class="form-control-icon">
                                            <i class="bi bi-person py-2"></i>
                                        </div>
                                        @error('full_name')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-1">
                                <div class="form-group has-icon-left mandatory @error('nik'){{ 'is-invalid' }}@enderror">
                                    <label for="nik" class="form-label">NIK</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control py-2" placeholder="e.g. 1050241708900001"
                                            id="nik" name="nik" value="{{ old('nik') ?? $userData->nik }}"
                                            maxlength="16" />
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
                                    class="form-group has-icon-left mandatory @error('username'){{ 'is-invalid' }}@enderror">
                                    <label for="username" class="form-label">Username</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control py-2" placeholder="alfianchii"
                                            id="username" name="username"
                                            value="{{ old('username') ?? $userData->username }}" maxlength="255" />
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
                                    class="form-group has-icon-left mandatory @error('email'){{ 'is-invalid' }}@enderror">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="position-relative">
                                        <input type="email" class="form-control py-2"
                                            placeholder="e.g. alfian.ganteng@gmail.com" id="email" name="email"
                                            value="{{ old('email') ?? $userData->email }}" maxlength="255" />
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
                                <div class="form-group has-icon-left mandatory @error('nip'){{ 'is-invalid' }}@enderror">
                                    <label for="nip" class="form-label">NIP</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control py-2" placeholder="e.g. 1050241708"
                                            id="nip" name="nip" value="{{ old('nip') ?? $userUnique->nip }}"
                                            maxlength="18" />
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-1">
                                <div class="form-group">
                                    <label
                                        class="@if ($userData->profile_picture) {{ 'd-block' }} @endif{{ 'form-label' }} @error('profile_picture'){{ 'text-danger' }}@enderror">Foto</label>
                                    <div class="position-relative">
                                        {{-- Image preview --}}
                                        @if ($isUserImageExist($userData->profile_picture))
                                            <div class="mb-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Hapus foto profil kamu."
                                                    class="btn btn-danger px-2 pt-2"
                                                    data-confirm-user-profile-picture-destroy="true"
                                                    data-unique="{{ base64_encode($userData->id_user) }}">
                                                    <span data-confirm-user-profile-picture-destroy="true"
                                                        data-unique="{{ base64_encode($userData->id_user) }}"
                                                        class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>

                                            @if (File::exists(public_path('images/' . $userData->profile_picture)))
                                                <img class="img-fluid bg-nav box-gradient rounded mb-3 col-sm-5"
                                                    src="{{ asset('images/' . $userData->profile_picture) }}"
                                                    alt="User Avatar" />
                                            @else
                                                <img class="img-fluid bg-nav box-gradient rounded mb-3 col-sm-5"
                                                    src="{{ asset('storage/' . $userData->profile_picture) }}"
                                                    alt="User Avatar" />
                                            @endif
                                        @endif

                                        {{-- Auto crop image file uploader --}}
                                        <input type="file" id="profile_picture" class="image-crop-filepond"
                                            name="profile_picture" />

                                        @error('profile_picture')
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

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- Forget error alert config --}}
    @if (session()->has('alert') &&
            array_key_exists('config', session('alert')) &&
            json_decode(session('alert')['config'], true)['icon'] === 'error')
        {{ Session::forget('alert') }}
    @endif

    {{-- Filepond: image auto crop --}}
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
    @vite(['resources/js/filepond/image-crop.js'])
    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/user/user.js'])
@endsection
