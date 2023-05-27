@extends('dashboard.layouts.main')

@section('links')
    @cannot('student')
        {{-- Simple DataTable --}}
        <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable.css') }}" />
    @endcannot
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>{{ $greeting }}, {{ auth()->user()->name }}!</h2>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
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
        <div class="page-content mt-4">
            @can('admin')
                <section class="row">
                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div class="col-6 col-lg-3 col-md-6">
                                <a href="/dashboard#daftar-keluhan">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldShow"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">
                                                        Keluhan
                                                    </h6>
                                                    <h6 class="font-extrabold mb-0">
                                                        {{ $complaintsCount }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <a href="/dashboard/users?status=officer">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                    <div class="stats-icon blue mb-2">
                                                        <i class="iconly-boldProfile"></i>
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
                                <a href="/dashboard/users?status=student">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                    <div class="stats-icon green mb-2">
                                                        <i class="iconly-boldAdd-User"></i>
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
                                <a href="/dashboard/responses">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldBookmark"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">
                                                        Tanggapan
                                                    </h6>
                                                    <h6 class="font-extrabold mb-0">
                                                        {{ $yourResponsesCount }}
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
                                        <h3>Statistik Keluhan dan Tanggapan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-complaint">
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
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Statistik Tanggapan Kamu</h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-your-responses">
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
                        <div class="row" id="daftar-keluhan">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Daftar Keluhan</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped" id="table1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Judul Keluhan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($complaints as $complaint)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            {{ $complaint->title }}
                                                        </td>
                                                        <td>
                                                            @if ($complaint->status == 0)
                                                                <span class="badge bg-danger">
                                                                    Belum diproses
                                                                </span>
                                                            @elseif ($complaint->status == 1)
                                                                <span class="badge bg-secondary">
                                                                    Sedang diproses
                                                                </span>
                                                            @elseif ($complaint->status == 2)
                                                                <span class="badge bg-success">
                                                                    Selesai
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @if ($complaint->status == 2)
                                                                    <a data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Rincian dari keluhan milik {{ $complaint->student->user->name }}."
                                                                        href="/dashboard/responses/create/{{ $complaint->slug }}"
                                                                        class="btn btn-info px-2 pt-2">
                                                                        <span class="fa-fw fa-lg select-all fas"></span>
                                                                    </a>
                                                                @elseif($complaint->status < 2)
                                                                    <a data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Menanggapi keluhan milik {{ $complaint->student->user->name }}."
                                                                        href="/dashboard/responses/create/{{ $complaint->slug }}"
                                                                        class="btn btn-warning px-2 pt-2">
                                                                        <span class="fa-fw fa-lg select-all fas"></span>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            <p class="text-center mt-3">Tidak ada tanggapan :(</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <div class="card-body py-4 px-4">
                                <div class="text-center">
                                    <div class="avatar avatar-xl mb-3">
                                        @if (auth()->user()->image)
                                            <img src="{{ asset('storage/' . auth()->user()->image) }}" />
                                        @else
                                            <img src="{{ asset('assets/static/images/faces/1.jpg') }}" />
                                        @endif
                                    </div>
                                    <div class="name">
                                        <h5 class="font-bold">{{ auth()->user()->name }}</h5>
                                        <h6 class="text-muted mb-0">
                                            {{ htmlspecialchars('@' . auth()->user()->username) }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Keluhan Terbaru</h4>
                            </div>
                            <div class="card-content pb-4">
                                @forelse ($recentComplaints as $complaint)
                                    <a href="/dashboard/responses/create/{{ $complaint->slug }}">
                                        <div class="recent-message d-flex px-4 py-3">
                                            <div class="avatar avatar-lg">
                                                @if ($complaint->student->user->image)
                                                    <img src="{{ asset('storage/' . $complaint->student->user->image) }}"
                                                        alt="User avatar" />
                                                @else
                                                    @if ($complaint->student->user->gender == 'L')
                                                        <img src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                            alt="User avatar" />
                                                    @else
                                                        <img src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                            alt="User avatar" />
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="name ms-4">
                                                <h5 class="mb-1">{{ $complaint->student->user->name }}</h5>
                                                <h6 class="text-muted mb-0">
                                                    {{ htmlspecialchars('@' . $complaint->student->user->username) }}
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="alert alert-warning" role="alert">
                                            <h4 class="alert-heading">Tidak ada keluhan :(</h4>
                                        </div>
                                    </div>
                                @endforelse
                                {{-- <div class="px-4">
                                <button class="btn btn-block btn-xl btn-outline-primary font-bold mt-3">
                                    Start Conversation
                                </button>
                            </div> --}}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Tanggapan</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-response-genders">
                                    <div class="d-flex justify-content-center skeleton-loading">
                                        <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Keluhan</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-complaint-genders">
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
                        <div class="card">
                            <div class="card-header">
                                <h3>Tanggapan Terbaru</h3>
                            </div>
                            <div class="card-body">
                                @forelse ($recentResponses as $response)
                                    <div class="row g-0 px-4 mt-3 mb-4 pb-2">
                                        <div class="col-md-2 d-flex align-items-start">
                                            @if ($response->officer->user->image)
                                                <img width="200"
                                                    src="{{ asset('storage/' . $response->officer->user->image) }}"
                                                    alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                            @else
                                                @if ($response->officer->user->gender == 'L')
                                                    <img width="200" src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                        alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                                @else
                                                    <img width="200" src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                        alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-md-10">
                                            <div class="card-body">
                                                <div class="text-md-start text-center">
                                                    <h4 class="card-title">{{ $response->officer->user->name }}</h4>
                                                    <small class="card-subtitle mb-2 text-muted">
                                                        {{ $response->created_at->diffForHumans() }}
                                                    </small>
                                                    <p class="card-text">{!! $response->body !!}</p>
                                                </div>
                                                {{-- <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Reply</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary">Report</button>
                                                </div>
                                                <small class="text-muted">Likes: 15</small>
                                            </div> --}}
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
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
            @endcan

            @can('officer')
                <section class="row">
                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div class="col-6 col-lg-3 col-md-6">
                                <a href="/dashboard#daftar-keluhan">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldShow"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">
                                                        Keluhan
                                                    </h6>
                                                    <h6 class="font-extrabold mb-0">
                                                        {{ $complaintsCount }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon blue mb-2">
                                                    <i class="iconly-boldProfile"></i>
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
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon green mb-2">
                                                    <i class="iconly-boldAdd-User"></i>
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
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <a href="/dashboard/responses">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldBookmark"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">
                                                        Tanggapan
                                                    </h6>
                                                    <h6 class="font-extrabold mb-0">
                                                        {{ $yourResponsesCount }}
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
                                        <h3>Statistik Tanggapan Kamu</h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-your-responses">
                                            <div id="chart-your-responses">
                                                <div class="d-flex justify-content-center skeleton-loading">
                                                    <div class="spinner-border" style="width: 3rem; height: 3rem"
                                                        role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="daftar-keluhan">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Daftar Keluhan</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped" id="table1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Judul Keluhan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($complaints as $complaint)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td>
                                                            {{ $complaint->title }}
                                                        </td>
                                                        <td>
                                                            @if ($complaint->status == 0)
                                                                <span class="badge bg-danger">
                                                                    Belum diproses
                                                                </span>
                                                            @elseif ($complaint->status == 1)
                                                                <span class="badge bg-secondary">
                                                                    Sedang diproses
                                                                </span>
                                                            @elseif ($complaint->status == 2)
                                                                <span class="badge bg-success">
                                                                    Selesai
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                @if ($complaint->status == 2)
                                                                    <a data-bs-toggle="tooltip"
                                                                        data-bs-original-title="Rincian dari keluhan milik {{ $complaint->student->user->name }}."
                                                                        href="/dashboard/responses/create/{{ $complaint->slug }}"
                                                                        class="btn btn-info px-2 pt-2">
                                                                        <span class="fa-fw fa-lg select-all fas"></span>
                                                                    </a>
                                                                @elseif($complaint->status < 2)
                                                                    <div class="me-2">
                                                                        <a data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Menanggapi keluhan milik {{ $complaint->student->user->name }}."
                                                                            href="/dashboard/responses/create/{{ $complaint->slug }}"
                                                                            class="btn btn-warning px-2 pt-2">
                                                                            <span class="fa-fw fa-lg select-all fas"></span>
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            <p class="text-center mt-3">Tidak ada tanggapan :(</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <div class="card-body py-4 px-4">
                                <div class="text-center">
                                    <div class="avatar avatar-xl mb-3">
                                        @if (auth()->user()->image)
                                            <img src="{{ asset('storage/' . auth()->user()->image) }}" />
                                        @else
                                            <img src="{{ asset('assets/static/images/faces/1.jpg') }}" />
                                        @endif
                                    </div>
                                    <div class="name">
                                        <h5 class="font-bold">{{ auth()->user()->name }}</h5>
                                        <h6 class="text-muted mb-0">
                                            {{ htmlspecialchars('@' . auth()->user()->username) }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Keluhan Terbaru</h4>
                            </div>
                            <div class="card-content pb-4">
                                @forelse ($recentComplaints as $complaint)
                                    <a href="/dashboard/responses/create/{{ $complaint->slug }}">
                                        <div class="recent-message d-flex px-4 py-3">
                                            <div class="avatar avatar-lg">
                                                @if ($complaint->student->user->image)
                                                    <img src="{{ asset('storage/' . $complaint->student->user->image) }}"
                                                        alt="User avatar" />
                                                @else
                                                    @if ($complaint->student->user->gender == 'L')
                                                        <img src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                            alt="User avatar" />
                                                    @else
                                                        <img src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                            alt="User avatar" />
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="name ms-4">
                                                <h5 class="mb-1">{{ $complaint->student->user->name }}</h5>
                                                <h6 class="text-muted mb-0">
                                                    {{ htmlspecialchars('@' . $complaint->student->user->username) }}
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="alert alert-warning" role="alert">
                                            <h4 class="alert-heading">Tidak ada keluhan :(</h4>
                                        </div>
                                    </div>
                                @endforelse
                                {{-- <div class="px-4">
                                <button class="btn btn-block btn-xl btn-outline-primary font-bold mt-3">
                                    Start Conversation
                                </button>
                            </div> --}}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Tanggapan</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-response-genders">
                                    <div id="chart-your-responses">
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Tanggapan Terbaru</h3>
                            </div>
                            <div class="card-body">
                                @forelse ($recentResponses as $response)
                                    <div class="row g-0 px-4 mt-3 mb-4 pb-2">
                                        <div class="col-md-2 d-flex align-items-start">
                                            @if ($response->officer->user->image)
                                                <img width="200"
                                                    src="{{ asset('storage/' . $response->officer->user->image) }}"
                                                    alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                            @else
                                                @if ($response->officer->user->gender == 'L')
                                                    <img width="200" src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                        alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                                @else
                                                    <img width="200" src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                        alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-md-10">
                                            <div class="card-body">
                                                <div class="text-md-start text-center">
                                                    <h4 class="card-title">{{ $response->officer->user->name }}</h4>
                                                    <small class="card-subtitle mb-2 text-muted">
                                                        {{ $response->created_at->diffForHumans() }}
                                                    </small>
                                                    <p class="card-text">{!! $response->body !!}</p>
                                                </div>
                                                {{-- <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Reply</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary">Report</button>
                                                </div>
                                                <small class="text-muted">Likes: 15</small>
                                            </div> --}}
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
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
            @endcan

            @can('student')
                <section class="row">
                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div class="col-6">
                                <a href="/dashboard/complaints">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldShow"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">
                                                        Keluhan
                                                    </h6>
                                                    <h6 class="font-extrabold mb-0">
                                                        {{ $yourComplaintsCount }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="/dashboard#recent-responses">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5" id="tanggapan-student">
                                            <div class="row">
                                                <div
                                                    class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldBookmark"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">
                                                        Tanggapan
                                                    </h6>
                                                    <h6 class="font-extrabold mb-0">
                                                        {{ $responsesStudentCount }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="d-none">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Statistik Keluhan Kamu</h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-your-complaints">
                                            <div id="chart-your-responses">
                                                <div class="d-flex justify-content-center skeleton-loading">
                                                    <div class="spinner-border" style="width: 3rem; height: 3rem"
                                                        role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
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
                            <div class="card-body py-4 px-4">
                                <div class="text-center">
                                    <div class="avatar avatar-xl mb-3">
                                        @if (auth()->user()->image)
                                            <img src="{{ asset('storage/' . auth()->user()->image) }}" />
                                        @else
                                            <img src="{{ asset('assets/static/images/faces/1.jpg') }}" />
                                        @endif
                                    </div>
                                    <div class="name">
                                        <h5 class="font-bold">{{ auth()->user()->name }}</h5>
                                        <h6 class="text-muted mb-0">
                                            {{ htmlspecialchars('@' . auth()->user()->username) }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Keluhan Terbaru</h4>
                            </div>
                            <div class="card-content pb-4">
                                @forelse ($recentComplaints as $complaint)
                                    <a href="/dashboard/complaints/{{ $complaint->slug }}">
                                        <div class="recent-message d-flex px-4 py-3">
                                            <div class="name ms-4">
                                                <h5 class="mb-1">{{ $complaint->title }}</h5>
                                                <h6 class="text-muted mb-0">
                                                    {{ $complaint->excerpt }}
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="recent-message d-flex px-4 py-3">
                                        <div class="alert alert-warning" role="alert">
                                            <h4 class="alert-heading">Tidak ada keluhan :(</h4>
                                        </div>
                                    </div>
                                @endforelse
                                {{-- <div class="px-4">
                                    <button class="btn btn-block btn-xl btn-outline-primary font-bold mt-3">
                                        Start Conversation
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="recent-responses">
                        <div class="card">
                            <div class="card-header">
                                <h3>Tanggapan Terbaru</h3>
                            </div>
                            <div class="card-body">
                                @forelse ($recentResponsesStudent as $response)
                                    <a class="text-subtitle text-muted"
                                        href="/dashboard/complaints/{{ $response->complaint->slug }}">
                                        <div class="row g-0 px-4 mt-3 mb-4 pb-2">
                                            <div class="col-md-2 d-flex align-items-start">
                                                @if ($response->officer->user->image)
                                                    <img width="200"
                                                        src="{{ asset('storage/' . $response->officer->user->image) }}"
                                                        alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                                @else
                                                    @if ($response->officer->user->gender == 'L')
                                                        <img width="200"
                                                            src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                            alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                                    @else
                                                        <img width="200"
                                                            src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                            alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-md-10">
                                                <div class="card-body">
                                                    <div class="text-md-start text-center">
                                                        <h4 class="card-title">{{ $response->officer->user->name }}</h4>
                                                        <small class="card-subtitle mb-2 text-muted">
                                                            {{ $response->created_at->diffForHumans() }}
                                                        </small>
                                                        <p class="card-text">{!! $response->body !!}</p>
                                                    </div>
                                                    {{-- <div class="d-flex justify-content-between align-items-center">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-sm btn-outline-secondary">Reply</button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-secondary">Report</button>
                                                        </div>
                                                        <small class="text-muted">Likes: 15</small>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
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
            @endcan
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Need: Apexcharts -->
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    {{-- Dashboard --}}
    @vite(['resources/js/dashboard.js'])

    @cannot('student')
        {{-- Simple DataTable --}}
        <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
        {{-- Simple DataTable --}}
        @vite(['resources/js/simple-datatable/responses.js'])
    @endcannot
@endsection
