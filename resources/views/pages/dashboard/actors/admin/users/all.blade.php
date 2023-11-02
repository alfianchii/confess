@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- Simple DataTable --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable.css') }}" />
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Daftar Pengguna</h2>
                    <p class="text-subtitle text-muted">
                        Keseluruhan data setiap pengguna.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a data-bs-toggle="tooltip" data-bs-original-title="Lakukan registrasi seorang pengguna."
                            href="/dashboard/users/register" class="btn btn-success px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span> Registrasi
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
                                Pengguna
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3>Pengguna</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Dibuat Pada</th>
                                <th>Data</th>
                                <th>Terakhir Login</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($isUserImageExist($user->profile_picture))
                                            @if (File::exists(public_path('images/' . $user->profile_picture)))
                                                <img class="rounded" width="100"
                                                    src="{{ asset('images/' . $user->profile_picture) }}"
                                                    alt="User Avatar" />
                                            @else
                                                <img class="rounded" width="100"
                                                    src="{{ asset('storage/' . $user->profile_picture) }}"
                                                    alt="User Avatar" />
                                            @endif
                                        @else
                                            @if ($user->gender === 'L')
                                                <img class="rounded" width="100"
                                                    src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                    alt="User Avatar" />
                                            @else
                                                <img class="rounded" width="100"
                                                    src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                    alt="User Avatar" />
                                            @endif
                                        @endif
                                    </td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>
                                        @if ($user->userRole->role->role_name === 'student')
                                            <span class="badge bg-success">
                                                Student
                                            </span>
                                        @elseif($user->userRole->role->role_name === 'officer')
                                            <span class="badge bg-warning">
                                                Officer
                                            </span>
                                        @elseif($user->userRole->role->role_name === 'admin')
                                            <span class="badge bg-info">
                                                Admin
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('j F Y, \a\t H.i') }}</td>
                                    <td>
                                        @if ($user->flag_active === 'Y')
                                            <span class="badge bg-light-success">Active</span>
                                        @else
                                            <span class="badge bg-light-danger">Non-active</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->last_login_at)
                                            {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                                        @else
                                            <span class="badge bg-light-danger">Not yet</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            {{-- --------------------------------- Rules --}}
                                            @if ($user->userRole->role->role_name !== 'admin')
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Sunting pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                                        href="/dashboard/users/details/{{ $user->username }}/edit"
                                                        class="btn btn-warning px-2 pt-2">
                                                        <span class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                                @if ($user->flag_active === 'Y')
                                                    <div class="me-2">
                                                        <a data-bs-toggle="tooltip"
                                                            data-bs-original-title="Non-aktifkan pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                                            class="btn btn-danger px-2 pt-2"
                                                            data-confirm-user-destroy="true"
                                                            data-unique="{{ base64_encode($user->id_user) }}">
                                                            <span data-confirm-user-destroy="true"
                                                                data-unique="{{ base64_encode($user->id_user) }}"
                                                                class="fa-fw fa-lg select-all fas"></span>
                                                        </a>
                                                    </div>
                                                @elseif ($user->flag_active === 'N')
                                                    <div class="me-2">
                                                        <a data-bs-toggle="tooltip"
                                                            data-bs-original-title="Aktifkan pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                                            class="btn btn-success px-2 pt-2"
                                                            data-confirm-user-activate="true"
                                                            data-unique="{{ base64_encode($user->id_user) }}">
                                                            <span data-confirm-user-activate="true"
                                                                data-unique="{{ base64_encode($user->id_user) }}"
                                                                class="fa-fw fa-lg select-all fas"></span>
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Ganti role pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                                        href="/dashboard/users/details/{{ $user->username }}/role"
                                                        class="btn btn-light px-2 pt-2">
                                                        <span class="text-black fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                            @endif

                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Rincian dari pengguna {{ htmlspecialchars('@' . $user->username) }}."
                                                    href="/dashboard/users/details/{{ $user->username }}"
                                                    class="btn btn-info px-2 pt-2">
                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-center mt-3">Tidak ada pengguna :(</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    {{-- Simple DataTable --}}
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    @vite(['resources/js/simple-datatable/user/user.js'])
@endsection
