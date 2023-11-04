@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Ganti Password</h2>
                    <p class="text-subtitle text-muted">
                        Menjadikan akun yang kamu miliki lebih aman dengan mengganti password.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="{{ back()->getTargetUrl() }}" data-bs-toggle="tooltip"
                            data-bs-original-title="Kembali ke halaman sebelumnya." class="btn btn-secondary px-2 pt-2 me-1">
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
                                Password
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
                        <h3 class="card-title">Password</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form" action="/dashboard/users/account/password/update" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-12 mb-1">
                                <div
                                    class="form-group has-icon-left mandatory @error('current_password'){{ 'is-invalid' }}@enderror">
                                    <label for="password" class="form-label">Password Saat Ini</label>
                                    <div class="d-flex flex-row-reverse align-items-center position-relative"
                                        id="wrapper">
                                        <input type="password" class="form-control py-2 mt-1"
                                            placeholder="e.g. 4kuBu7uhM3dk1t" id="password" name="current_password"
                                            maxlength="255" />
                                        <div class="form-control-icon pt-1">
                                            <i class="bi bi-key"></i>
                                        </div>
                                        <button type="button" class="btn bg-transparent show-password" id="show-password"
                                            data-bs-toggle="tooltip" data-bs-title="Tampilkan/sembunyikan password.">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-1">
                                <div
                                    class="form-group has-icon-left mandatory @error('new_password'){{ 'is-invalid' }}@enderror">
                                    <label for="password-confirmation" class="form-label">Password Baru</label>
                                    <div class="d-flex flex-row-reverse align-items-center position-relative"
                                        id="wrapper">
                                        <input type="password" class="form-control py-2 mt-1"
                                            placeholder="e.g. 4kuBu7uhM3dk1t" id="password-confirmation" name="new_password"
                                            maxlength="255" />
                                        <div class="form-control-icon pt-1">
                                            <i class="bi bi-key-fill"></i>
                                        </div>
                                        <button type="button" class="btn bg-transparent show-password"
                                            id="show-password-confirmation" data-bs-toggle="tooltip"
                                            data-bs-title="Tampilkan/sembunyikan password.">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </button>
                                    </div>
                                    @error('new_password')
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
        </section>
    </div>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
    {{-- Display password --}}
    @vite(['resources/js/display-password/password-confirmation.js'])
@endsection
