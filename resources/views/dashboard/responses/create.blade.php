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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Tanggapan</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/dashboard/responses" method="POST" data-parsley-validate
                                    enctype="multipart/form-data">
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
                                            <div class="form-group mandatory">
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

                                                    <input id="body" name="body" value="{{ old('body') }}"
                                                        type="hidden">
                                                    <div id="editor">
                                                        {!! old('body') !!}
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
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    {{-- Quill --}}
    @vite(['resources/js/quill.js'])
    <script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
@endsection
