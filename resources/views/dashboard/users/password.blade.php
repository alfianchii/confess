@extends('dashboard.layouts.main')

@section('links')
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
                                Password
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 order-md-3">
                    @if (session()->has('errorPassword'))
                        <div class="alert bg alert-dismissible show fade text-white mb-4">
                            {{ session('errorPassword') }}
                            <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
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
                    <form class="form" action="/dashboard/user/account/password/{{ $user->username }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-12 mb-1">
                                <div class="form-group has-icon-left @error('current_password') is-invalid @enderror">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control py-2" placeholder="e.g. 4kuBu7uhM3dk1t"
                                            id="current_password" name="current_password" maxlength="255" />
                                        <div class="form-control-icon">
                                            <i class="bi bi-key py-2"></i>
                                        </div>
                                        @error('current_password')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-1">
                                <div class="form-group has-icon-left @error('new_password') is-invalid @enderror">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control py-2" placeholder="e.g. 4kuBu7uhM3dk1t"
                                            id="new_password" name="new_password" maxlength="255" />
                                        <div class="form-control-icon">
                                            <i class="bi bi-key-fill py-2"></i>
                                        </div>
                                        @error('new_password')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show_change_pw">
                                    <label class="form-check-label" id="label-show_pw" for="show_change_pw">
                                        Tampilkan Password
                                    </label>
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
    {{-- Display password --}}
    @vite('resources/js/display-password/change-password.js')
@endsection
