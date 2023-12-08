@extends('pages.landing-page.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <section class="container px-4">
        <div class="page-heading mb-0">
            <div class="page-title">
                <div class="row justify-content-center">
                    <div class="col-12 mb-3 header-about mt-3">
                        <h2>Profil</h2>
                        <p class="text-subtitle text-muted">
                            Rincian pengguna dari akun <span
                                class="font-bold">{{ htmlspecialchars('@' . $theUser->username) }}</span>.
                        </p>
                        <hr>
                        <div class="mb-3">
                            <a href="{{ back()->getTargetUrl() }}" data-bs-toggle="tooltip"
                                data-bs-original-title="Kembali ke halaman sebelumnya."
                                class="btn btn-secondary px-2 pt-2 me-1">
                                <span class="fa-fw fa-lg select-all fas text-white"></span>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h3 class="card-title">Pengguna</h3>
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
                                        @if ($theUser->userRole->role->role_name == 'student')
                                            <p>NISN:
                                                <span style="font-weight: 400;" class="text-muted">
                                                    {{ $theUser->student->nisn ?? '-' }}
                                                </span>
                                            </p>
                                        @else
                                            <p>NIP:
                                                <span style="font-weight: 400;" class="text-muted">
                                                    {{ $theUser->officer->nip ?? '-' }}
                                                </span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="font-bold">
                                        <p>Email: <span style="font-weight: 400;"
                                                class="text-muted">{{ $theUser->email }}</span></p>
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
                                                class="badge bg-nav">{{ ucwords($theUser->userRole->role->role_name) }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
@endsection
