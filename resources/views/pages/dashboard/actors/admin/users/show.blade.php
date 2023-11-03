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
                        Keseluruhan data dari akun {{ $theUser->full_name }}.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="{{ back()->getTargetUrl() }}" data-bs-toggle="tooltip"
                            data-bs-original-title="Kembali ke halaman sebelumnya."
                            class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                            Kembali
                        </a>
                        {{-- --------------------------------- Rules --}}
                        @if ($theUser->userRole->role->role_name !== 'admin')
                            <a data-bs-toggle="tooltip"
                                data-bs-original-title="Sunting pengguna {{ htmlspecialchars('@' . $theUser->username) }}."
                                href="/dashboard/users/details/{{ $theUser->username }}/edit"
                                class="btn btn-warning px-2 pt-2 me-1">
                                <span class="fa-fw fa-lg select-all fas"></span>
                            </a>
                            @if ($theUser->flag_active === 'Y')
                                <a data-bs-toggle="tooltip"
                                    data-bs-original-title="Non-aktifkan pengguna {{ htmlspecialchars('@' . $theUser->username) }}."
                                    class="btn btn-danger px-2 pt-2 me-1" data-confirm-user-destroy="true"
                                    data-unique="{{ base64_encode($theUser->id_user) }}">
                                    <span data-confirm-user-destroy="true"
                                        data-unique="{{ base64_encode($theUser->id_user) }}"
                                        class="fa-fw fa-lg select-all fas"></span>
                                </a>
                            @elseif ($theUser->flag_active === 'N')
                                <a data-bs-toggle="tooltip"
                                    data-bs-original-title="Aktifkan pengguna {{ htmlspecialchars('@' . $theUser->username) }}."
                                    class="btn btn-success px-2 pt-2 me-1" data-confirm-user-activate="true"
                                    data-unique="{{ base64_encode($theUser->id_user) }}">
                                    <span data-confirm-user-activate="true"
                                        data-unique="{{ base64_encode($theUser->id_user) }}"
                                        class="fa-fw fa-lg select-all fas"></span>
                                </a>
                            @endif
                        @else
                            <a data-bs-toggle="tooltip"
                                data-bs-original-title="Ganti role pengguna {{ htmlspecialchars('@' . $theUser->username) }}."
                                href="/dashboard/users/details/{{ $theUser->username }}/role"
                                class="btn btn-light px-2 pt-2 me-1">
                                <span class="text-black fa-fw fa-lg select-all fas"></span>
                            </a>
                        @endif
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
                        <h3 class="card-title">Pengguna {{ htmlspecialchars('@' . $theUser->username) }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center flex-column mb-3">
                        @if ($isUserImageExist($theUser->profile_picture))
                            @if (File::exists(public_path('images/' . $theUser->profile_picture)))
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('images/' . $theUser->profile_picture) }}" alt="User Avatar" />
                            @else
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('storage/' . $theUser->profile_picture) }}" alt="User Avatar" />
                            @endif
                        @else
                            @if ($theUser->gender === 'L')
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('assets/static/images/faces/2.jpg') }}" alt="User Avatar" />
                            @else
                                <img width="150" class="rounded-circle"
                                    src="{{ asset('assets/static/images/faces/5.jpg') }}" alt="User Avatar" />
                            @endif
                        @endif

                        <h4 class="mt-4">{{ $theUser->full_name }}</h4>

                        <small class="text-muted">({{ htmlspecialchars('@' . $theUser->username) }})</small>
                    </div>

                    <div class="divider">
                        <div class="divider-text">{{ $theUser->created_at->format('d F Y') }}</div>
                    </div>

                    <div class="container text-center justify-content-center">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="font-bold">
                                    <p>NIK: <span style="font-weight: 400;" class="text-muted">{{ $theUser->nik }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="font-bold">
                                    <p>Email: <span style="font-weight: 400;"
                                            class="text-muted">{{ $theUser->email }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="font-bold">
                                    <p>Gender:
                                        <span style="font-weight: 400;" class="text-muted">
                                            @if ($theUser->gender == 'L')
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
                                            class="badge bg-primary">{{ ucwords($theUser->userRole->role->role_name) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="font-bold">
                                    @if ($theUser->userRole->role->role_name == 'student')
                                        <p>NISN:
                                            <span style="font-weight: 400;" class="text-muted">
                                                {{ $theUser->student->nisn ? $theUser->student->nisn : '-' }}
                                            </span>
                                        </p>
                                    @else
                                        <p>NIP:
                                            <span style="font-weight: 400;" class="text-muted">
                                                {{ $theUser->officer->nip ? $theUser->officer->nip : '-' }}
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
