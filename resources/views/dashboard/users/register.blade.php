@extends('dashboard.layouts.main')

@section('links')
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Registrasi Pengguna</h2>
                    <p class="text-subtitle text-muted">
                        Daftarkan pengguna untuk melakukan sesuatu di Confess.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="/dashboard/users" class="btn btn-secondary me-1"><span data-feather="arrow-left"></span>
                            Kembali</a>
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard/users">Users</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Register
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
                                <form class="form" action="/dashboard/users" method="POST" data-parsley-validate
                                    enctype="multipart/form-data">
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
                                                        <div class="parsley-error filled" id="parsley-id-1" aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
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
                                                        <div class="parsley-error filled" id="parsley-id-2" aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
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
                                                        <div class="parsley-error filled" id="parsley-id-1" aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
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
                                                        <div class="parsley-error filled" id="parsley-id-1"
                                                            aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
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
                                                        value="{{ old('password') }}" maxlength="255" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-key py-2"></i>
                                                    </div>
                                                    @error('password')
                                                        <div class="parsley-error filled" id="parsley-id-1"
                                                            aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
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
                                                        name="password_confirmation"
                                                        value="{{ old('password_confirmation') }}" maxlength="255" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-key-fill py-2"></i>
                                                    </div>
                                                    @error('password_confirmation')
                                                        <div class="parsley-error filled" id="parsley-id-1"
                                                            aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
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
                                                    <div class="parsley-error filled" id="parsley-id-1" aria-hidden="false">
                                                        <span class="parsley-required">{{ $message }}</span>
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
                                                            <label class="form-check-label form-label"
                                                                for="level-student">
                                                                Student
                                                            </label>
                                                        </div>
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="level"
                                                                id="level-officer" value="officer"
                                                                @if (old('level') == 'officer') checked @endif />
                                                            <label class="form-check-label form-label"
                                                                for="level-officer">
                                                                Officer
                                                            </label>
                                                        </div>
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="level"
                                                                id="level-admin" value="admin"
                                                                @if (old('level') == 'admin') checked @endif />
                                                            <label class="form-check-label form-label" for="level-admin">
                                                                Admin
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                @error('level')
                                                    <div class="parsley-error filled" id="parsley-id-1" aria-hidden="false">
                                                        <span class="parsley-required">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group ">
                                                <div class="position-relative">
                                                    <label for="image"
                                                        class="form-label @error('image') is-invalid @enderror">Foto</label>

                                                    <!-- Image preview -->
                                                    <img class="img-preview img-fluid mb-3 col-sm-5 rounded">
                                                    <!-- File uploader with image preview -->
                                                    <input class="form-control @error('image') is-invalid @enderror"
                                                        type="file" id="image" name="image">

                                                    @error('image')
                                                        <div class="parsley-error filled" id="parsley-id-3"
                                                            aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
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
    {{-- Form: parsley --}}
    <script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/parsley.js') }}"></script>
    {{-- Image and Sluggable --}}
    @vite(['resources/js/image.js'])
@endsection
