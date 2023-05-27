@extends('dashboard.layouts.main')

@section('links')
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Kronologi Kejadian</h2>
                    <p class="text-subtitle text-muted">
                        Rincian dari keluhan yang kamu alami.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a data-bs-toggle="tooltip" data-bs-original-title="Kembali ke halaman sebelumnya."
                            href="{{ $previousUrl }}" class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                        </a>
                        <a data-bs-toggle="tooltip" data-bs-original-title="Lakukan penyuntingan terhadap keluhan kamu."
                            href="/dashboard/complaints/{{ $complaint->slug }}/edit" class="btn btn-warning px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas"></span>
                        </a>
                        <a data-bs-toggle="tooltip" data-bs-original-title="Hapus keluhan." href="#"
                            class="btn btn-danger px-2 pt-2 me-1 delete-record" data-slug="{{ $complaint->slug }}">
                            <span data-slug="{{ $complaint->slug }}"
                                class="delete-record fa-fw fa-lg select-all fas"></span>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard/complaints">Keluhan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Rincian
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
                    <h3 class="card-title d-inline-block">Keluhan</h3> <small
                        class="text-muted">({{ $complaint->privacy }})</small>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h4>{{ $complaint->title }}</h4>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="me-4">
                            <p>
                                <span class="fw-bold">Tanggal:</span> {{ $complaint->date }}
                            </p>
                            <p>
                                <span class="fw-bold">Tempat kejadian:</span>
                                @if ($complaint->place == 'in')
                                    Dalam Sekolah
                                @elseif ($complaint->place == 'out')
                                    Luar Sekolah
                                @endif
                            </p>
                        </div>
                        <div class="me-4">
                            <p>
                                <span class="fw-bold">Kategori:</span> {{ $complaint->category->name }}
                            </p>
                            <p>
                                <span class="fw-bold me-1">Status:</span>
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
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="px-5 py-3 d-flex justify-content-center">
                        <a href="#">
                            @if ($complaint->image)
                                <img class="img-fluid rounded" data-bs-toggle="modal" data-bs-target="#imageDetail"
                                    src="{{ asset("storage/$complaint->image") }}" alt="{{ $complaint->category->name }}">
                            @else
                                <img class="img-fluid rounded" data-bs-toggle="modal" data-bs-target="#imageDetail"
                                    src="{{ asset('images/no-image-2.jpg') }}" alt="{{ $complaint->category->name }}">
                            @endif
                        </a>

                        {{-- Modal --}}
                        <div class="modal fade text-left" id="imageDetail" tabindex="-1" aria-labelledby="myModalLabel17"
                            style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel17">
                                            Foto
                                        </h4>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                <line x1="18" y1="6" x2="6" y2="18">
                                                </line>
                                                <line x1="6" y1="6" x2="18" y2="18">
                                                </line>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center">
                                            @if ($complaint->image)
                                                <img class="img-fluid rounded" data-bs-toggle="modal"
                                                    data-bs-target="#imageDetail"
                                                    src="{{ asset("storage/$complaint->image") }}"
                                                    alt="{{ $complaint->category->name }}">
                                            @else
                                                <img class="img-fluid rounded" data-bs-toggle="modal"
                                                    data-bs-target="#imageDetail"
                                                    src="{{ asset('images/no-image-2.jpg') }}"
                                                    alt="{{ $complaint->category->name }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p>
                        {!! $complaint->body !!}
                    </p>
                </div>
            </div>
            {{-- Response --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tanggapan</h3>
                </div>
                <div class="card-body">
                    @forelse ($responses as $response)
                        <div class="row g-0 px-4 mt-5 mb-4 pb-2">
                            <div class="col-md-2 d-flex align-items-start">
                                @if ($response->officer->user->image)
                                    <img width="200"
                                        src="{{ asset('storage') . '/' . $response->officer->user->image }}"
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
                        </div>
                        <hr>
                    @empty
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Tidak ada tanggapan :(</h4>
                            <p>Belum ada tanggapan dari pihak terkait.</p>
                        </div>
                    @endforelse
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
