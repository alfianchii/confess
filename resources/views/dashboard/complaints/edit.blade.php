@extends('dashboard.layouts.main')

@section('links')
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

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
                    <h3>Edit Keluhan</h3>
                    <p class="text-subtitle text-muted">
                        Ceritakan keluhan yang kamu miliki.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary me-1"><span
                                data-feather="arrow-left"></span>
                            Kembali</a>
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
                                Edit
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
                            <h4 class="card-title mb-0">Kronologi</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/dashboard/complaints/{{ $complaint->slug }}" method="POST"
                                    data-parsley-validate enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('title') is-invalid @enderror">
                                                <label for="title" class="form-label">Judul</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="Judul keluhan" id="title" name="title"
                                                        value="{{ old('title', $complaint->title) }}" />
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
                                                    <input type="text" class="form-control py-2" placeholder="Slugable"
                                                        id="slug" name="slug"
                                                        value="{{ old('slug', $complaint->slug) }}" />
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
                                                <label for="date" class="form-label">Date</label>
                                                <div class="position-relative">
                                                    <input type="date" class="form-control py-2"
                                                        placeholder="Judul keluhan" id="date" name="date"
                                                        value="{{ old('date', $complaint->date) }}" />
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
                                                            <option @if (old('category_id', $complaint->category->slug) == $category->slug) selected @endif
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
                                        <div class="col-12 mb-1">
                                            <div
                                                class="form-group mandatory @error('place') text-danger is-invalid @enderror">
                                                <fieldset>
                                                    <label class="form-label">
                                                        Tempat Kejadian
                                                    </label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="place"
                                                            id="place-in" value="in"
                                                            @if (old('place', $complaint->place) == 'in') checked @endif />
                                                        <label class="form-check-label form-label" for="place-in">
                                                            Dalam sekolah
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="place"
                                                            id="place-out" value="out"
                                                            @if (old('place', $complaint->place) == 'out') checked @endif />
                                                        <label class="form-check-label form-label" for="place-out">
                                                            Luar sekolah
                                                        </label>
                                                    </div>
                                                </fieldset>
                                                @error('place')
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
                                                    <label for="image"
                                                        class="@if ($complaint->image) d-block @endif form-label @error('image') is-invalid @enderror">Foto</label>
                                                    <input type="hidden" name="oldImage"
                                                        value="{{ $complaint->image }}">

                                                    <!-- Image preview -->
                                                    @if ($complaint->image)
                                                        <img src="{{ asset('storage/' . $complaint->image) }}"
                                                            class="img-preview img-fluid mb-3 col-sm-5 rounded">
                                                    @else
                                                        <img class="img-preview img-fluid mb-3 col-sm-5 rounded">
                                                    @endif

                                                    <!-- File uploader with image preview -->
                                                    <input class="form-control @error('image') is-invalid @enderror"
                                                        type="file" id="image" name="image">

                                                    @error('image')
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
                                        <div class="col-12 mb-1">
                                            <div class="form-group mandatory @error('body') is-invalid @enderror">
                                                <div class="position-relative">
                                                    <label for="body" class="form-label">Isi Keluhan</label>

                                                    <input id="body" name="body"
                                                        value="{{ old('body', $complaint->body) }}" type="hidden">
                                                    <div id="editor">
                                                        {!! old('body', $complaint->body) !!}
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

    {{-- SweetAlert --}}
    @vite(['resources/js/sweetalert/swalSingle.js'])
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
