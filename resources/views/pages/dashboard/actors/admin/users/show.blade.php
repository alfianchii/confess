@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
@endsection

{{-- --------------------------------- Content --}}
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
                        <a id="back-to-page-button" data-bs-toggle="tooltip"
                            data-bs-original-title="Kembali ke halaman sebelumnya."
                            class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                            Kembali
                        </a>
                        {{-- --------------------------------- Rules --}}
                        @if ($user->userRole->role->role_name !== 'admin')
                            <a data-bs-toggle="tooltip"
                                data-bs-original-title="Sunting pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                href="/dashboard/users/details/{{ $user->username }}/edit"
                                class="btn btn-warning px-2 pt-2 me-1">
                                <span class="fa-fw fa-lg select-all fas"></span>
                            </a>
                            @if ($user->flag_active === 'Y')
                                <a data-bs-toggle="tooltip"
                                    data-bs-original-title="Non-aktifkan pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                    class="btn btn-danger px-2 pt-2 me-1" data-confirm-user-destroy="true"
                                    data-unique="{{ base64_encode($user->id_user) }}">
                                    <span data-confirm-user-destroy="true" data-unique="{{ base64_encode($user->id_user) }}"
                                        class="fa-fw fa-lg select-all fas"></span>
                                </a>
                            @elseif ($user->flag_active === 'N')
                                <a data-bs-toggle="tooltip"
                                    data-bs-original-title="Aktifkan pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                    class="btn btn-success px-2 pt-2 me-1" data-confirm-user-activate="true"
                                    data-unique="{{ base64_encode($user->id_user) }}">
                                    <span data-confirm-user-activate="true"
                                        data-unique="{{ base64_encode($user->id_user) }}"
                                        class="fa-fw fa-lg select-all fas"></span>
                                </a>
                            @endif
                        @endif
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
                        @if ($isUserImageExist($user->profile_picture))
                            @if (File::exists(public_path('images/' . $user->profile_picture)))
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('images/' . $user->profile_picture) }}" alt="User Avatar" />
                            @else
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('storage/' . $user->profile_picture) }}" alt="User Avatar" />
                            @endif
                        @else
                            @if ($user->gender === 'L')
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('assets/static/images/faces/2.jpg') }}" alt="User Avatar" />
                            @else
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('assets/static/images/faces/5.jpg') }}" alt="User Avatar" />
                            @endif
                        @endif

                        <h4 class="mt-4">{{ $user->full_name }}</h4>

                        <small class="text-muted">({{ htmlspecialchars('@' . $user->username) }})</small>
                    </div>

                    <div class="divider">
                        <div class="divider-text">{{ $user->created_at->format('d F Y') }}</div>
                    </div>

                    <div class="container text-center justify-content-center">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="font-bold">
                                    <p>NIK: <span style="font-weight: 400;" class="text-muted">{{ $user->nik }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="font-bold">
                                    <p>Email: <span style="font-weight: 400;" class="text-muted">{{ $user->email }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="font-bold">
                                    <p>Gender:
                                        <span style="font-weight: 400;" class="text-muted">
                                            @if ($user->gender == 'L')
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
                                    <p>Status: <span
                                            class="badge bg-primary">{{ ucwords($user->userRole->role->role_name) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="font-bold">
                                    @if ($user->userRole->role->role_name == 'student')
                                        <p>NISN:
                                            <span style="font-weight: 400;" class="text-muted">
                                                {{ $user->student->nisn ? $user->student->nisn : '-' }}
                                            </span>
                                        </p>
                                    @else
                                        <p>NIP:
                                            <span style="font-weight: 400;" class="text-muted">
                                                {{ $user->officer->nip ? $user->officer->nip : '-' }}
                                            </span>
                                        </p>
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

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/user/user.js'])
@endsection
