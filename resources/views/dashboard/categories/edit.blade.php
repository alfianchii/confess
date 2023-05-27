@extends('dashboard.layouts.main')

@section('links')
    {{-- Image preview --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}" />
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Sunting Kategori</h2>
                    <p class="text-subtitle text-muted">
                        Lakukan penyuntingan terhadap suatu kategori.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a data-bs-toggle="tooltip" data-bs-original-title="Kembali ke halaman sebelumnya."
                            href="{{ $previousUrl }}" class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                        </a>
                        <a data-bs-toggle="tooltip" data-bs-original-title="Hapus kategori." href="#"
                            class="btn btn-danger px-2 pt-2 delete-record" data-slug="{{ $category->slug }}">
                            <span data-slug="{{ $category->slug }}"
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
                                <a href="/dashboard/categories">Kategori</a>
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
                            <h3 class="card-title mb-0">Kategori</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/dashboard/categories/{{ $category->slug }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('name') is-invalid @enderror">
                                                <label for="name" class="form-label">Nama</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="Nama kategori" id="name" name="name"
                                                        value="{{ old('name', $category->name) }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-card-heading py-2"></i>
                                                    </div>
                                                    @error('name')
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
                                                        id="slug" name="slug"
                                                        value="{{ old('slug', $category->slug) }}" />
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
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group mandatory @error('description') is-invalid @enderror">
                                                <div class="position-relative">
                                                    <label for="description" class="form-label">Deskripsi Kategori</label>

                                                    <input id="description" name="description"
                                                        value="{{ old('description', $category->description) }}"
                                                        type="hidden">
                                                    <div id="editor">
                                                        {!! old('description', $category->description) !!}
                                                    </div>

                                                    @error('description')
                                                        <div class="parsley-error filled" id="parsley-id-3" aria-hidden="false">
                                                            <span class="parsley-required">{{ $message }}</span>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group ">
                                                <div class="position-relative">
                                                    <label for="image"
                                                        class="@if ($category->image) d-block @endif form-label @error('image') is-invalid @enderror">Foto</label>
                                                    <input type="hidden" name="oldImage"
                                                        value="{{ $category->image }}">

                                                    <!-- Image preview -->
                                                    @if ($category->image)
                                                        <img src="{{ asset("storage/$category->image") }}"
                                                            class="img-preview img-fluid mb-3 col-sm-5 rounded">
                                                    @endif

                                                    <!-- File uploader with image preview -->
                                                    <input type="file" class="image-crop-filepond" name="image"
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
    @vite(['resources/js/quill/categories.js'])
    <script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
    {{-- Sluggable --}}
    @vite(['resources/js/sluggable/slug.js'])
    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/swalSingle.js'])
    {{-- Image  --}}
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
@endsection
