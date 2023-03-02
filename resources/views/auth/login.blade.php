@extends('layouts.main')

@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 mb-3">
                <h2>Login</h2>
                <p class="text-subtitle">Masuk dengan akun yang sudah didaftarkan oleh Admin.</p>
            </div>

            <div class="col-12 mb-3">
                <section class="section text-center">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Akun Anda</h3>
                        </div>

                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-6">
                                    <form action="/login" method="post">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label for="username">Username</label>
                                            <small class="text-muted">eg.<i>alfianchii</i></small>
                                            <input type="text" class="form-control mt-1" id="username"
                                                name="username" />
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="password">Password</label>
                                            <small class="text-muted">eg.<i>p4k3n4ny4</i></small>
                                            <input type="password" class="form-control mt-1" id="password"
                                                name="password" />
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
