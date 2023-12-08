@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h2>{{ $greeting }}, {{ $userData->full_name }}!</h2>
                </div>
                <div class="col-12 col-md-4 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                Dashboard
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        {{-- Entry Point Start --}}
        <div class="page-content mt-4">
            <section class="row">
                <div class="col-12 col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body py-4 px-4">
                                    <div class="text-center">
                                        <div class="avatar avatar-xl mb-3">
                                            @if ($isUserImageExist($userData->profile_picture))
                                                @if (File::exists(public_path('images/' . $userData->profile_picture)))
                                                    <img src="{{ asset('images/' . $userData->profile_picture) }}"
                                                        alt="User Avatar" />
                                                @else
                                                    <img src="{{ asset('storage/' . $userData->profile_picture) }}"
                                                        alt="User Avatar" />
                                                @endif
                                            @else
                                                @if ($userData->gender === 'L')
                                                    <img src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                        alt="User Avatar" />
                                                @else
                                                    <img src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                        alt="User Avatar" />
                                                @endif
                                            @endif
                                        </div>
                                        <div class="name">
                                            <h5 class="font-bold">{{ $userData->full_name }}</h5>
                                            <h6 class="text-muted mb-0">
                                                {{ htmlspecialchars('@' . $userData->username) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row user-select-none">
                        <div class="col-6 col-lg-3 col-md-6">
                            <a style="cursor: pointer" data-bs-toggle="tooltip"
                                data-bs-original-title="Jumlah pengguna dengan status sebagai 'officer' yang aktif.">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon mb-2" style="background-color: #ff66cc;">
                                                    <i class="iconly-boldAdd-User"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">
                                                    Pegawai
                                                </h6>
                                                <h6 class="font-extrabold mb-0">
                                                    {{ $officersCount }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <a style="cursor: pointer" data-bs-toggle="tooltip"
                                data-bs-original-title="Jumlah pengguna dengan status sebagai 'student' yang aktif.">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon mb-2" style="background-color: #ff6677;">
                                                    <i class="iconly-boldProfile"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">
                                                    Murid
                                                </h6>
                                                <h6 class="font-extrabold mb-0">
                                                    {{ $studentsCount }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <a style="cursor: pointer" onclick="window.location.href='/dashboard/confessions'"
                                data-bs-toggle="tooltip"
                                data-bs-original-title="Jumlah seluruh pengakuan yang telah dibuat oleh 'student'.">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon red mb-2">
                                                    <i class="iconly-boldMessage"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">
                                                    Pengakuan
                                                </h6>
                                                <h6 class="font-extrabold mb-0">
                                                    {{ $confessionsCount }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <a style="cursor: pointer" onclick="window.location.href='/dashboard/confessions/responses'"
                                data-bs-toggle="tooltip"
                                data-bs-original-title="Jumlah seluruh tanggapan yang telah dibuat oleh 'officer' ataupun 'student' terhadap suatu pengakuan (system's responses not included).">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon purple mb-2">
                                                    <i class="iconly-boldFolder"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">
                                                    Tanggapan
                                                </h6>
                                                <h6 class="font-extrabold mb-0">
                                                    {{ $responsesCount }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Statistik Kamu</h3>
                                </div>
                                <div class="card-body">
                                    <div id="chart-your-statistics">
                                        <div class="d-flex justify-content-center skeleton-loading">
                                            <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Pengakuan Terbaru</h4>
                        </div>
                        <div class="card-content pb-4">
                            @forelse ($recentConfessions as $confession)
                                <a href="/dashboard/confessions/{{ $confession->slug }}/responses/create">
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="avatar avatar-lg">
                                            @if ($isUserImageExist($confession->student->user->profile_picture))
                                                @if (File::exists(public_path('images/' . $confession->student->user->profile_picture)))
                                                    <img src="{{ asset('images/' . $confession->student->user->profile_picture) }}"
                                                        alt="User Avatar" />
                                                @else
                                                    <img src="{{ asset('storage/' . $confession->student->user->profile_picture) }}"
                                                        alt="User Avatar" />
                                                @endif
                                            @else
                                                @if ($confession->student->user->gender === 'L')
                                                    <img src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                        alt="User Avatar" />
                                                @else
                                                    <img src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                        alt="User Avatar" />
                                                @endif
                                            @endif
                                        </div>
                                        <div class="name ms-4">
                                            <h5 class="mb-1">{{ $confession->student->user->full_name }}</h5>
                                            <h6 class="text-muted mb-0">
                                                {{ htmlspecialchars('@' . $confession->student->user->username) }}
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="recent-message d-flex px-4 py-3">
                                    <div class="alert alert-warning" role="alert">
                                        <h4 class="alert-heading">Tidak ada pengakuan :(</h4>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Pengakuan</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-confession-genders">
                                <div class="d-flex justify-content-center skeleton-loading">
                                    <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    {{-- Response --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tanggapan Terbaru</h3>
                        </div>
                        <div class="card-body">
                            @forelse ($recentResponses as $response)
                                <a class="text-muted"
                                    href="/dashboard/confessions/{{ $response->confession->slug }}/responses/create?response={{ base64_encode($response->id_confession_response) }}&page={{ $response->page }}">
                                    <div class="px-4 mb-1">
                                        <div class="p-4 pb-0 px-0">
                                            <div class="d-flex">
                                                {{-- Profile picture --}}
                                                <div class="col-3 col-md-1">
                                                    <div class="avatar avatar-lg mb-3 w-100">
                                                        @if ($isUserImageExist($response->user->profile_picture))
                                                            @if (File::exists(public_path('images/' . $response->user->profile_picture)))
                                                                <img src="{{ asset('images/' . $response->user->profile_picture) }}"
                                                                    alt="User Avatar" />
                                                            @else
                                                                <img src="{{ asset('storage/' . $response->user->profile_picture) }}"
                                                                    alt="User Avatar" />
                                                            @endif
                                                        @else
                                                            @if ($response->user->gender === 'L')
                                                                <img src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                                    alt="User Avatar" />
                                                            @else
                                                                <img src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                                    alt="User Avatar" />
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Details --}}
                                                <div class="col-11">
                                                    <div class="text-start pe-4">
                                                        <span class="mb-0 d-flex">
                                                            <small class="card-subtitle text-muted">
                                                                {{ $response->created_at->format('d F Y, \a\t H:i') }}
                                                                @if ($response->updated_by)
                                                                    <span class="fst-italic">(disunting)</span>
                                                                @endif
                                                            </small>

                                                            {{-- System's response --}}
                                                            @if ($response->system_response === 'Y')
                                                                <small
                                                                    class="card-subtitle text-muted ms-1 fst-italic">(system)</small>
                                                            @endif
                                                        </span>

                                                        {{-- Highlighted name --}}
                                                        @if ($response->id_user === $userData->id_user)
                                                            <a
                                                                class="font-bold mb-3 d-inline-block">{{ $response->user->full_name }}</a>
                                                        @else
                                                            <p class="font-bold">{{ $response->user->full_name }}</p>
                                                        @endif

                                                        <div class="mb-4">{!! $response->response !!}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($response->attachment_file)
                                                <div class="mb-4">
                                                    <a href="{{ asset("storage/$response->attachment_file") }}"
                                                        target="_blank">
                                                        <div class="attachment-file position-relative">
                                                            <div class="attachment-file-body text-center">
                                                                <i class="far fa-file-alt icon-9x"></i>
                                                            </div>
                                                            <div class="attachment-file-footer">
                                                                <a href="{{ asset("storage/$response->attachment_file") }}"
                                                                    target="_blank" class="btn btn-primary">
                                                                    <i class="far fas fa-box-open me-2"></i> Open it
                                                                    up!
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <hr class="m-0">
                                </a>
                            @empty
                                <div class="alert alert-warning" role="alert">
                                    <h4 class="alert-heading">Tidak ada tanggapan :(</h4>
                                    <p>Belum ada tanggapan dari pihak terkait.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </div>
        {{-- Entry Point End --}}
    </div>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- Apexcharts --}}
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    {{-- Admin Dashboard --}}
    @vite(['resources/js/dashboard/officer.js'])
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
@endsection
