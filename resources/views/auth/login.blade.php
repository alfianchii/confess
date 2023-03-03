@extends('layouts.main')

@section('content')
    <div class="page-content">
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
    </div>
@endsection
