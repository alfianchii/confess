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
                    <h2>Buat Tanggapan</h2>
                    <p class="text-subtitle text-muted">
                        Berikan pendapat kamu mengenai suatu keluhan.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-1"><span
                                data-feather="arrow-left"></span>
                            Kembali</a>
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard/responses">Responses</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    {{-- Complaint --}}
                    <div class="card mb-5">
                        <div class="card-header">
                            <h3 class="card-title d-inline-block">Keluhan</h3> <small
                                class="text-muted">({{ $complaint->privacy }})</small>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h4>{{ $complaint->title }}</h4>
                                <h6 class="text-muted">
                                    {{ $complaint->student->user->name }}
                                    ({{ htmlspecialchars('@' . $complaint->student->user->username) }})
                                </h6>
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
                                            src="{{ asset("storage/$complaint->image") }}"
                                            alt="{{ $complaint->category->name }}">
                                    @else
                                        <img class="img-fluid rounded" data-bs-toggle="modal" data-bs-target="#imageDetail"
                                            src="https://source.unsplash.com/random/600x600?school {{ $complaint->category->name }}"
                                            alt="{{ $complaint->category->name }}">
                                    @endif
                                </a>

                                {{-- Modal --}}
                                <div class="modal fade text-left" id="imageDetail" tabindex="-1"
                                    aria-labelledby="myModalLabel17" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel17">
                                                    Foto
                                                </h4>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-x">
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
                                                            src="https://source.unsplash.com/random/600x600?school {{ $complaint->category->name }}"
                                                            alt="{{ $complaint->category->name }}">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
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

                    {{-- Form --}}
                    <div class="card mb-5">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Tanggapan</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/dashboard/responses" method="POST" data-parsley-validate
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-12 m-0 p-0">
                                            <div class="form-group mandatory">
                                                {{-- To controller --}}
                                                <input hidden type="text" class="form-control" id="complaint_id"
                                                    name="complaint_id" readonly="readonly"
                                                    value="{{ $complaint->id }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group mandatory @error('body') is-invalid @enderror">
                                                <div class="position-relative">
                                                    <label for="body" class="form-label">Isi Tanggapan</label>

                                                    <input id="body" name="body" value="{{ old('body') }}"
                                                        type="hidden">
                                                    <div id="editor">
                                                        {!! old('body') !!}
                                                    </div>

                                                    @error('body')
                                                        <div class="parsley-error filled" id="parsley-id-3"
                                                            aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="form-group mandatory @error('status') is-invalid @enderror">
                                                <label for="status" class="form-label">Status</label>

                                                @if ($complaint->status == 2)
                                                    <p class="mb-0">Keluhan telah selesai.</p>
                                                @else
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="no-process" value="0" checked=""
                                                            @if (old('status', $complaint->status) == '0') checked @endif>
                                                        <label class="form-check-label" for="no-process">
                                                            Belum diproses
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="process" value="1"
                                                            @if (old('status', $complaint->status) == '1') checked @endif>
                                                        <label class="form-check-label" for="process">
                                                            Sedang diproses
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            id="done" value="2"
                                                            @if (old('status', $complaint->status) == '2') checked @endif>
                                                        <label class="form-check-label" for="done">
                                                            Selesai
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mt-2 d-flex justify-content-start">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                                            <img src="{{ asset('storage') . '/' . $response->officer->user->image }}"
                                                alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                        @else
                                            @if ($response->officer->user->gender == 'L')
                                                <img src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                    alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                            @else
                                                <img src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                    alt="User avatar" class="img-fluid rounded-circle mx-auto">
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $response->officer->user->name }}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">
                                                {{ $response->created_at->diffForHumans() }}
                                            </h6>
                                            <p class="card-text">{!! $response->body !!}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if ($response->officer_nik === auth()->user()->nik)
                                                    <div class="btn-group" id="responses">
                                                        <div class="me-2">
                                                            <a href="/dashboard/responses/{{ $response->id }}/edit"
                                                                class="badge bg-warning"><span
                                                                    data-feather="edit"></span></a>
                                                        </div>

                                                        <div class="me-2">
                                                            <a href="/dashboard/responses/{{ $response->id }}"
                                                                class="badge bg-info"><span data-feather="eye"></span></a>
                                                        </div>

                                                        <div class="me-2">
                                                            <a href="#"
                                                                class="badge bg-danger border-0 delete-record"
                                                                data-slug="{{ $response->id }}"><span
                                                                    data-feather="x-circle" class="delete-record"
                                                                    data-slug="{{ $response->id }}"></span></a>
                                                        </div>
                                                    </div>
                                                    {{-- <small class="text-muted">Likes: 15</small> --}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @empty
                                <div class="alert alert-warning" role="alert">
                                    <h4 class="alert-heading">Tidak ada tanggapan</h4>
                                    <p>Belum ada tanggapan dari pihak terkait.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    {{-- Sweetalert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/swalMulti.js'])
    {{-- Quill --}}
    @vite(['resources/js/quill.js'])
    <script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
@endsection
