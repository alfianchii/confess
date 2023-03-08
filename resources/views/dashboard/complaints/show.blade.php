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
                    <h3>Kronologi Kejadian</h3>
                    <p class="text-subtitle text-muted">
                        Detail dari keluhan yang kamu alami.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="/dashboard/complaints" class="btn btn-secondary me-1"><span
                                data-feather="arrow-left"></span>
                            Kembali</a>
                        <a href="/dashboard/complaints/{{ $complaint->slug }}/edit" class="badge bg-warning me-1"><span
                                data-feather="edit"></span> Edit</a>
                        <a href="#" class="badge bg-danger border-0 delete-record me-1"
                            data-slug="{{ $complaint->slug }}"><span data-feather="x-circle" class="delete-record"
                                data-slug="{{ $complaint->slug }}"></span> Hapus</a>
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard/complaints">Complaints</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Detail
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
                    <h3 class="card-title">Keluhan</h3>
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
                                {{-- <img class="img-fluid rounded" data-bs-toggle="modal" data-bs-target="#imageDetail"
                                src="https://source.unsplash.com/random/1000x2000?{{ $complaint->category->name }}"
                                alt="{{ $complaint->category->name }}"> --}}
                                <img class="img-fluid rounded" data-bs-toggle="modal" data-bs-target="#imageDetail"
                                    src="https://images.unsplash.com/photo-1633008808000-ce86bff6c1ed?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyN3x8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                                    alt="{{ $complaint->category->name }}">
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
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
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
                                                {{-- <img class="img-fluid rounded" data-bs-toggle="modal" data-bs-target="#imageDetail"
                                src="https://source.unsplash.com/random/1000x2000?{{ $complaint->category->name }}"
                                alt="{{ $complaint->category->name }}"> --}}
                                                <img class="img-fluid rounded" data-bs-toggle="modal"
                                                    data-bs-target="#imageDetail"
                                                    src="https://images.unsplash.com/photo-1633008808000-ce86bff6c1ed?ixid=MnwxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwyN3x8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
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
                        <div class="row g-0 px-4 mt-3 mb-4 pb-2">
                            <div class="col-md-2 d-flex align-items-center">
                                <img src="{{ asset('assets/images/faces/5.jpg') }}" alt="User avatar"
                                    class="img-fluid rounded-circle mx-auto">
                            </div>
                            <div class="col-md-10">
                                <div class="card-body">
                                    @dd($complaint->responses[0])
                                    <h5 class="card-title">{{ $response->officer }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">March 8, 2023</h6>
                                    <p class="card-text">This is a comment. Lorem ipsum dolor sit amet, consectetur
                                        adipiscing elit. Pellentesque id commodo purus. Nunc interdum eget ipsum eu
                                        molestie.</p>
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
                    @empty
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
