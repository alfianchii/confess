@extends('dashboard.layouts.main')

@section('links')
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Sunting Tanggapan</h2>
                    <p class="text-subtitle text-muted">
                        Lakukan penyuntingan terhadap suatu tanggapan.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a data-bs-toggle="tooltip" data-bs-original-title="Kembali ke halaman sebelumnya."
                            href="{{ $previousUrl }}" class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas  text-white"></span>
                        </a>
                        @if ($complaint->status != 2)
                            <a data-bs-toggle="tooltip" data-bs-original-title="Hapus tanggapan yang sudah kamu berikan."
                                href="#" class="btn btn-danger px-2 pt-2 delete-record me-1"
                                data-slug="{{ $response->id }}">
                                <span data-slug="{{ $response->id }}"
                                    class="delete-record fa-fw fa-lg select-all fas"></span>
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
                                <a href="/dashboard/responses">Tanggapan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Sunting
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title d-inline-block">Tanggapan</h3> <a
                                href="/dashboard/responses/create/{{ $complaint->slug }}"><small>({{ $complaint->privacy }})</small></a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/dashboard/responses/{{ $response->id }}" method="POST"
                                    data-parsley-validate>
                                    @method('PUT')
                                    @csrf

                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group">
                                                <label class="form-label" for="complaint-own">Kepemilikan Keluhan </label>
                                                {{-- To display --}}
                                                <input type="text" class="form-control" id="complaint-own"
                                                    readonly="readonly" value="{{ $complaint->student->user->name }}">
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="form-group">
                                                <label class="form-label" for="complaint-category">Kategori
                                                </label>
                                                {{-- To display --}}
                                                <input type="text" class="form-control" id="complaint-category"
                                                    readonly="readonly" value="{{ $complaint->category->name }}">
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="form-group">
                                                <label class="form-label" for="complaint-display">Judul</label>
                                                {{-- To display --}}
                                                <input type="text" class="form-control" id="complaint-display"
                                                    readonly="readonly" value="{{ $complaint->title }}">
                                                {{-- To controller --}}
                                                <input hidden type="text" class="form-control" id="complaint_id"
                                                    name="complaint_id" readonly="readonly" value="{{ $complaint->id }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group mandatory @error('body') is-invalid @enderror">
                                                <div class="position-relative">
                                                    <label for="body" class="form-label">Isi Tanggapan</label>

                                                    <input id="body" name="body"
                                                        value="{{ old('body', $response->body) }}" type="hidden">
                                                    <div id="editor">
                                                        {!! old('body', $response->body) !!}
                                                    </div>

                                                    @error('body')
                                                        <div class="parsley-error filled" id="parsley-id-3" aria-hidden="false">
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
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    {{-- Quill --}}
    @vite(['resources/js/quill/responses.js'])
    <script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
    {{-- SweetAlert --}}
    @vite(['resources/js/sweetalert/swalSingle.js'])
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
