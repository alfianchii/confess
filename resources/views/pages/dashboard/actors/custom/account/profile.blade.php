@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
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
                        <a href="{{ back()->getTargetUrl() }}" data-bs-toggle="tooltip"
                            data-bs-original-title="Kembali ke halaman sebelumnya."
                            class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                            Kembali
                        </a>
                        <a data-bs-toggle="tooltip" data-bs-original-title="Sunting data dari akun kamu."
                            href="/dashboard/users/account/settings" class="btn btn-warning px-2 pt-2 me-1">
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
                                Profil
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
                        <h3 class="card-title">Pengguna</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center flex-column mb-3">
                        @if ($isUserImageExist($userData->profile_picture))
                            @if (File::exists(public_path('images/' . $userData->profile_picture)))
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('images/' . $userData->profile_picture) }}" alt="User Avatar" />
                            @else
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('storage/' . $userData->profile_picture) }}" alt="User Avatar" />
                            @endif
                        @else
                            @if ($userData->gender === 'L')
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('assets/static/images/faces/2.jpg') }}" alt="User Avatar" />
                            @else
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('assets/static/images/faces/5.jpg') }}" alt="User Avatar" />
                            @endif
                        @endif

                        <h4 class="mt-4">{{ $userData->full_name }}</h4>

                        <small class="text-muted">({{ htmlspecialchars('@' . $userData->username) }})</small>
                    </div>

                    <div class="divider">
                        <div class="divider-text">{{ $userData->created_at->format('d F Y') }}</div>
                    </div>

                    <div class="container text-center justify-content-center">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="font-bold">
                                    <p>NIK: <span style="font-weight: 400;" class="text-muted">{{ $userData->nik }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="font-bold">
                                    <p>Email: <span style="font-weight: 400;"
                                            class="text-muted">{{ $userData->email }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="font-bold">
                                    <p>Gender:
                                        <span style="font-weight: 400;" class="text-muted">
                                            @if ($userData->gender == 'L')
                                                Laki-laki
                                            @else
                                                Perempuan
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="font-bold">
                                    <p>Status: <span class="badge bg-primary">{{ ucwords($userRole->role_name) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="font-bold">
                                    @if ($userRole->role_name == 'student')
                                        <p>NISN:
                                            <span style="font-weight: 400;" class="text-muted">
                                                {{ $userUnique->nisn ? $userUnique->nisn : '-' }}
                                            </span>
                                        </p>
                                    @else
                                        <p>NIP:
                                            <span style="font-weight: 400;" class="text-muted">
                                                {{ $userUnique->nip ? $userUnique->nip : '-' }}
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @can('admin')
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Non-active Your Account</h5>
                    </div>
                    <div class="card-body">
                        <p>Your account will be permanently deleted and cannot be restored, click "Touch me!" to
                            continue.</p>
                        <div class="form-check">
                            <div class="checkbox">
                                <input type="checkbox" id="iaggree" class="form-check-input">
                                <label for="iaggree">Touch me! If you agree to delete permanently.</label>
                            </div>
                        </div>
                        <div class="form-group my-2 d-flex justify-content-end">
                            <button data-confirm-user-non-active="true" data-unique={{ base64_encode($userData->id_user) }}
                                type="submit" class="btn btn-danger" id="btn-delete-account" disabled="">Non-active</button>
                        </div>
                    </div>
                </div>
            @endcan
        </section>
    </div>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/user/user.js'])
    @can('admin')
        {{-- Non-active account --}}
        @vite(['resources/js/utils/non-active-a-user.js'])
    @endcan
@endsection
