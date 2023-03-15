@extends('dashboard.layouts.main')

@section('links')
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />

    {{-- Form: select option --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
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
                        <a href="/dashboard/responses" class="btn btn-secondary me-1"><span
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
                                <a href="/dashboard/complaints">Complaints</a>
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
                                            <div class="form-group mandatory">
                                                <label for="complaints" class="form-label">Judul Keluhan</label>
                                                <select class="choices form-select" id="complaints" name="complaint_id">
                                                    @foreach ($categories as $category)
                                                        <optgroup label="{{ $category->name }}">
                                                            @forelse ($complaints as $complaint)
                                                                @if ($complaint->category->slug === $category->slug)
                                                                    <option
                                                                        @if (old('complaint_id') == $complaint->slug) selected @endif
                                                                        value="{{ $complaint->slug }}">
                                                                        {{ $complaint->title }}
                                                                        ({{ $complaint->student->user->name }})
                                                                    </option>
                                                                @endif
                                                            @empty
                                                                <option>Tidak ada keluhan</option>
                                                            @endforelse
                                                        </optgroup>
                                                    @endforeach
                                                </select>
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
    {{-- Jquery --}}
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    {{-- Form: parsley --}}
    <script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/parsley.js') }}"></script>
    {{-- Form: select option --}}
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-element-select.js') }}"></script>
    {{-- Image and Sluggable --}}
    @vite(['resources/js/image.js'])
@endsection
