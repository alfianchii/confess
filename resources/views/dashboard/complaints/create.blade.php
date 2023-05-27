@extends('dashboard.layouts.main')

@section('links')
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />

    {{-- Form: select option --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">

    {{-- Image preview --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}" />
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Buat Keluhan</h2>
                    <p class="text-subtitle text-muted">
                        Ceritakan keluhan yang kamu miliki.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a data-bs-toggle="tooltip" data-bs-original-title="Kembali ke halaman keluhan."
                            href="{{ $previousUrl }}" class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
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
                                Tambah
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
                            <h3 class="card-title mb-0">Kronologi</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/dashboard/complaints" method="POST" data-parsley-validate
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('title') is-invalid @enderror">
                                                <label for="title" class="form-label">Judul</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="Judul keluhan" id="title" name="title"
                                                        value="{{ old('title') }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-card-heading py-2"></i>
                                                    </div>
                                                    @error('title')
                                                        <div class="parsley-error filled" id="parsley-id-1" aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('slug') is-invalid @enderror">
                                                <label for="slug" class="form-label">Slug</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2" placeholder="Sluggable"
                                                        id="slug" name="slug" value="{{ old('slug') }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-pencil py-2"></i>
                                                    </div>
                                                    @error('slug')
                                                        <div class="parsley-error filled" id="parsley-id-2" aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('date') is-invalid @enderror">
                                                <label for="date" class="form-label">Tanggal Kejadian</label>
                                                <div class="position-relative">
                                                    <input type="date" class="form-control py-2"
                                                        placeholder="Judul keluhan" id="date" name="date"
                                                        value="{{ old('date') ?? date('Y-m-d') }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-calendar-day py-2"></i>
                                                    </div>
                                                    @error('date')
                                                        <div class="parsley-error filled" id="parsley-id-1" aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div class="form-group mandatory">
                                                <label for="categories" class="form-label">Kategori</label>
                                                <select class="choices form-select" id="categories" name="category_id">
                                                    <optgroup label="Kategori">
                                                        @forelse ($categories as $category)
                                                            <option @if (old('category_id') == $category->slug) selected @endif
                                                                value="{{ $category->slug }}">
                                                                {{ $category->name }}</option>
                                                        @empty
                                                            <option>No category</option>
                                                        @endforelse
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group mandatory @error('place') text-danger is-invalid @enderror">
                                                <fieldset>
                                                    <label class="form-label">
                                                        Tempat Kejadian
                                                    </label>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="place"
                                                                id="place-in" value="in"
                                                                @if (old('place') == 'in') checked @endif />
                                                            <label data-bs-toggle="tooltip"
                                                                data-bs-original-title="Tempat kejadian berada di dalam sekolah"
                                                                class="form-check-label form-label" for="place-in">
                                                                Dalam sekolah
                                                            </label>
                                                        </div>
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="place"
                                                                id="place-out" value="out"
                                                                @if (old('place') == 'out') checked @endif />
                                                            <label data-bs-toggle="tooltip"
                                                                data-bs-original-title="Tempat kejadian berada di luar sekolah"
                                                                class="form-check-label form-label" for="place-out">
                                                                Luar sekolah
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                @error('place')
                                                    <div class="parsley-error filled" id="parsley-id-1" aria-hidden="false">
                                                        <span class="parsley-required">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group mandatory @error('privacy') text-danger is-invalid @enderror">
                                                <fieldset>
                                                    <label class="form-label">
                                                        Kerahasian Keluhan
                                                    </label>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="privacy"
                                                                id="privacy-anonymous" value="anonymous"
                                                                @if (old('privacy') == 'anonymous') checked @endif />
                                                            <label data-bs-toggle="tooltip"
                                                                data-bs-original-title="Nama kamu dirahasiakan dari siswa lain."
                                                                class="form-check-label form-label"
                                                                for="privacy-anonymous">
                                                                Anonim
                                                            </label>
                                                        </div>
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="privacy"
                                                                id="privacy-public" value="public"
                                                                @if (old('privacy') == 'public') checked @endif />
                                                            <label data-bs-toggle="tooltip"
                                                                data-bs-original-title="Nama kamu bisa dilihat oleh siswa lain."
                                                                class="form-check-label form-label" for="privacy-public">
                                                                Publik
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                @error('privacy')
                                                    <div class="parsley-error filled" id="parsley-id-1" aria-hidden="false">
                                                        <span class="parsley-required">{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group ">
                                                <div class="position-relative">
                                                    <label for="image" class="form-label">Foto</label>

                                                    <!-- File uploader with image preview -->
                                                    <input type="file" class="image-preview-filepond" name="image"
                                                        id="image" />

                                                    @error('image')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group mandatory @error('body') is-invalid @enderror">
                                                <div class="position-relative">
                                                    <label for="body" class="form-label">Isi Keluhan</label>

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
    @vite(['resources/js/quill/complaints.js'])
    <script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
    {{-- Jquery --}}
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    {{-- Form: parsley --}}
    <script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/parsley.js') }}"></script>
    {{-- Form: select option --}}
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/form-element-select.js') }}"></script>
    {{-- Image and Sluggable --}}
    <script
        src="{{ asset('assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
    <script
        src="{{ asset('assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond/filepond.js') }}"></script>
    @vite(['resources/js/uploader/image.js'])
    @vite(['resources/js/sluggable/slug.js'])
@endsection
