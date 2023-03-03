@extends('auth.layouts.main')

@section('content')
    <div class="col-12 col-sm-5 bg">
        <div class=" d-flex pt-3 pt-sm-0">
            <a href="/" class=" ms-3 ms-sm-5 pt-3 mb-2 mb-sm-5 logo-login">
                <img src="../images/logoT.png" alt="illustrasi" width="20%" />
            </a>
            <div class="text-end me-3 ms-sm-5 pt-3 mb-2 mb-sm-5 d-block d-sm-none">
                <a href="/" class="text-white opacity-75">Kembali</a>
            </div>
        </div>
        <div class="text-center illus-login">
            <img src="../images/illust.png" alt="logo" width="60%" />
        </div>
    </div>

    <div class="col-12 col-sm-7">
        <div class="text-end pt-4 me-3 me-sm-5 d-sm-block d-none">
            <a href="/" class="text-secondary">Kembali</a>
        </div>
        <h1 class="w-100 fw-bold text-center mt-5 mt-sm-0 p-0 pt-sm-5 fs-3">MASUK</h1>
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card mt-5 p-sm-4 p-2 border-start-0 border-end-0 margin-form">
            <div class="card-body">
                <form action="/login" method="post" class="my-4">
                    @csrf
                    <div class="mb-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control p-2 mt-1 @error('username') is-invalid @enderror"
                            id="username" name="username" value="{{ old('username') }}" />
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control p-2 mt-1 @error('password') is-invalid @enderror"
                            id="password" name="password" />
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="text-end mt-3">
                            <a href="# " class="form-text">Lupa password?</a>
                        </div>

                    </div>
                    <div class="text-start mt-5">
                        <button type="submit" class="w-100 btn-color btn text-white btn-primary p-2">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            @include('auth.layouts.footer')
        </div>
    </div>
@endsection

{{-- <div class="page-content">
    <section class="row">
        <div class="col-12 mb-3">
            <h2>Login</h2>
            <p class="text-subtitle">Masuk dengan akun yang sudah didaftarkan oleh Admin.</p>

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="col-12 mb-3">
            <section class="section text-center">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Akun Anda</h3>
                    </div>

                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-8 col-md-6">
                                <form action="/login" method="post">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label for="username">Username</label>
                                        <small class="text-muted">eg.<i>alfianchii</i></small>
                                        <input type="text"
                                            class="form-control mt-1 @error('username') is-invalid @enderror"
                                            id="username" name="username" value="{{ old('username') }}" />

                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <small class="text-muted">eg.<i>p4k3n4ny4</i></small>
                                        <input type="password"
                                            class="form-control mt-1 @error('password') is-invalid @enderror"
                                            id="password" name="password" />

                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div> --}}
