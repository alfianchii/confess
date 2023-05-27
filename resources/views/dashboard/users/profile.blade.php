@extends('dashboard.layouts.main')

@section('links')
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Profil</h2>
                    <p class="text-subtitle text-muted">
                        Keseluruhan data akun yang kamu miliki.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a data-bs-toggle="tooltip" data-bs-original-title="Kembali ke halaman sebelumnya."
                            href="{{ $previousUrl }}" class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                        </a>
                        <a data-bs-toggle="tooltip" data-bs-original-title="Sunting akun kamu."
                            href="/dashboard/user/account/setting" class="btn btn-warning px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas"></span>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Akun
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            {{-- Complaint --}}
            <div class="card mb-5">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h3 class="card-title">Pengguna</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if ($user->image)
                            <img width="150" class="rounded-circle" src="{{ asset("storage/$user->image") }}"
                                alt="{{ $user->username }}">
                        @else
                            @if ($user->gender == 'L')
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('assets/static/images/faces/2.jpg') }}" alt="{{ $user->username }}">
                            @else
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('assets/static/images/faces/5.jpg') }}" alt="{{ $user->username }}">
                            @endif
                        @endif

                        <h4 class="mt-4">{{ $user->name }}</h4>

                        <small class="text-muted">({{ htmlspecialchars('@' . $user->username) }})</small>
                    </div>

                    <div class="divider">
                        {{-- <div class="divider-text">{{ htmlspecialchars('@' . $user->username) }}</div> --}}
                        <div class="divider-text">{{ $user->created_at->format('d F Y') }}</div>
                    </div>

                    <div class="container text-center justify-content-center">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="">
                                    <h6>NIK: <span class="text-muted">{{ $user->nik }}</span></h6>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="">
                                    <h6>Email: <span class="text-muted">{{ $user->email }}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="">
                                    <h6>Gender:
                                        <span class="text-muted">
                                            @if ($user->gender == 'L')
                                                Laki-laki
                                            @else
                                                Perempuan
                                            @endif
                                        </span>
                                    </h6>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="">
                                    <h6>Status: <span class="text-muted">{{ ucwords($user->level) }}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    @if ($user->level == 'student')
                                        <h6>NISN:
                                            <span class="text-muted">
                                                {{ $user->student->nisn ? $user->student->nisn : '-' }}
                                            </span>
                                        </h6>
                                    @else
                                        <h6>NIP:
                                            <span class="text-muted">
                                                {{ $user->officer->nip ? $user->officer->nip : '-' }}
                                            </span>
                                        </h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    {{-- SweetAlert --}}
    @vite(['resources/js/sweetalert/swalSingle.js'])
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
