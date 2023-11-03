@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- Image preview --}}
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
                    <h2>Registrasi Pengguna</h2>
                    <p class="text-subtitle text-muted">
                        Daftarkan pengguna untuk melakukan sesuatu di {{ config('web_config')['WEB_TITLE'] }}.
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
                                                class="form-group has-icon-left mandatory @error('full_name'){{ 'is-invalid' }}@enderror">
                                                <label for="full_name" class="form-label">Nama</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="e.g. Muhammad Alfian" id="full_name" name="full_name"
                                                        value="{{ old('full_name') }}" />
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
                                            <div
                                                class="form-group has-icon-left mandatory @error('nik'){{ 'is-invalid' }}@enderror">
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
                                                class="form-group has-icon-left mandatory @error('username'){{ 'is-invalid' }}@enderror">
                                                <label for="username" class="form-label">Username</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="e.g. alfianchii" id="username" name="username"
                                                        value="{{ old('username') }}" maxlength="255" />
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
                                                class="form-group has-icon-left mandatory @error('password'){{ 'is-invalid' }}@enderror">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="d-flex flex-row-reverse align-items-center position-relative"
                                                    id="wrapper">
                                                    <input type="password" class="form-control py-2 mt-1"
                                                        placeholder="e.g. 4kuBu7uhM3dk1t" id="password" name="password"
                                                        maxlength="255" />
                                                    <div class="form-control-icon pt-1">
                                                        <i class="bi bi-key"></i>
                                                    </div>
                                                    <button type="button" class="btn bg-transparent show-password"
                                                        id="show-password" data-bs-toggle="tooltip"
                                                        data-bs-title="Tampilkan/sembunyikan password.">
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
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('password_confirmation'){{ 'is-invalid' }}@enderror">
                                                <label for="password-confirmation" class="form-label">Konfirmasi
                                                    Password</label>
                                                <div class="d-flex flex-row-reverse align-items-center position-relative"
                                                    id="wrapper">
                                                    <input type="password" class="form-control py-2 mt-1"
                                                        placeholder="e.g. 4kuBu7uhM3dk1t" id="password-confirmation"
                                                        name="password_confirmation" maxlength="255" />
                                                    <div class="form-control-icon pt-1">
                                                        <i class="bi bi-key-fill"></i>
                                                    </div>
                                                    <button type="button" class="btn bg-transparent show-password"
                                                        id="show-password-confirmation" data-bs-toggle="tooltip"
                                                        data-bs-title="Tampilkan/sembunyikan password.">
                                                        <i class="bi bi-eye-slash-fill"></i>
                                                    </button>
                                                </div>
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group mandatory @error('gender'){{ 'is-invalid' }}@enderror">
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
                                                                @if (old('gender') == 'P') checked @endif />
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
                                        <div class="col-md-6 col-12 mb-1" id="role-name">
                                            <div class="col-12 mb-1">
                                                <fieldset class="form-group mandatory">
                                                    <label for="role"
                                                        class="form-label @error('role'){{ 'text-danger' }}@enderror">Role</label>
                                                    <select class="form-select" id="role" name="role">
                                                        {{-- <option label="Pilih role user ..."></option> --}}
                                                        @foreach ($roles as $role)
                                                            @if ($role->role_name != 'admin')
                                                                <option value="{{ $role->role_name }}"
                                                                    @if (old('role') === $role->role_name) {{ 'selected' }} @endif>
                                                                    {{ $role->description }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                                @error('role')
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
                                                    <label for="profile_picture" class="form-label">Foto</label>

                                                    <!-- Auto crop image file uploader -->
                                                    <input type="file" id="profile_picture"
                                                        class="image-crop-filepond" name="profile_picture" />

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
    @vite(['resources/js/filepond/image-crop.js'])
    {{-- Display password --}}
    @vite(['resources/js/display-password/password-confirmation.js'])
    {{-- Custom JS: select role --}}
    <script>
        const uniqueFields = generateUniqueFields();

        function createField() {
            const field = document.createElement("div");
            field.classList.add("col-12", "mb-1");
            return field;
        }

        function changeField(columnElement, selectElement, field) {
            const userRole = selectElement.value;
            newField = rolesValidate(userRole, field);
            columnElement.parentElement.append(newField);
        }

        function rolesValidate(userRole, field) {
            if (userRole === "officer")
                field.innerHTML = uniqueFields.nip;
            if (userRole === "student") field.innerHTML = uniqueFields.nisn;
            return field;
        }

        function generateUniqueFields() {
            return {
                nip: `
                    <div class="form-group has-icon-left mandatory @error('nip'){{ 'is-invalid' }}@enderror">
                        <label for="nip" class="form-label">NIP</label>
                        <div class="position-relative">
                            <input type="text" class="form-control py-2" placeholder="e.g. 105024170890000123" id="nip"
                                name="nip" value="{{ old('nip') }}" maxlength="18" />
                            <div class="form-control-icon">
                                <i class="bi bi-person-vcard py-2"></i>
                            </div>
                            @error('nip')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>`,

                nisn: `
                    <div class="form-group has-icon-left mandatory @error('nisn'){{ 'is-invalid' }}@enderror">
                        <label for="nisn" class="form-label">NISN</label>
                        <div class="position-relative">
                            <input type="text" class="form-control py-2" placeholder="e.g. 7090851024" id="nisn"
                                name="nisn" value="{{ old('nisn') }}" maxlength="10" />
                            <div class="form-control-icon">
                                <i class="bi bi-person-vcard py-2"></i>
                            </div>
                            @error('nisn')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>`,
            };
        }

        const roleNameField = document.getElementById("role-name");
        const selectRoleElement = document.getElementById("role");

        let newField = createField();
        changeField(roleNameField, selectRoleElement, newField);
        roleNameField.addEventListener("change", () =>
            changeField(roleNameField, event.target, newField)
        );
    </script>
@endsection
