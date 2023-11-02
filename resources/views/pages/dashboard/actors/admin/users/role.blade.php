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
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>WwwWWW Pengguna</h2>
                    <p class="text-subtitle text-muted">
                        Daftarkan pengguna untuk melakukan sesuatu di {{ config('web_config')['WEB_TITLE'] }}.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a id="back-to-page-button" data-bs-toggle="tooltip"
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
                                <form class="form" action="/dashboard/users/details/{{ $user->username }}/role/update"
                                    method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf

                                    <div class="row">
                                        <div class="col-12 mb-1" id="role-name">
                                            <div class="col-12 mb-1">
                                                <fieldset class="form-group">
                                                    <label for="role"
                                                        class="form-label @error('role'){{ 'text-danger' }}@enderror">Role</label>
                                                    <select class="form-select" id="role" name="role">
                                                        @foreach ($roles as $role)
                                                            @if ($role->role_name !== 'student')
                                                                <option value="{{ $role->role_name }}"
                                                                    @if (old('role', $user->userRole->role->role_name) === $role->role_name) {{ 'selected' }} @endif>
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
    {{-- Back to page --}}
    @vite(['resources/js/utils/back-to-page.js'])
    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/user/user.js'])
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
            if (userRole === "admin" || userRole === "officer")
                field.innerHTML = uniqueFields.nip;
            return field;
        }

        function generateUniqueFields() {
            return {
                nip: `
                      <div class="form-group has-icon-left mandatory @error('nip'){{ 'is-invalid' }}@enderror">
                          <label for="nip" class="form-label">NIP</label>
                          <div class="position-relative">
                              <input type="text" class="form-control py-2" placeholder="e.g. 105024170890000123" id="nip"
                                  name="nip" value="{{ old('nip') ?? $user->officer?->nip }}" maxlength="18" />
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
