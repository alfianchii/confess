@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />
    {{-- Form: select option --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Buat Panduan Aplikasi</h2>
                    <p class="text-subtitle text-muted">
                        Berikan panduan aplikasi yang baik agar pengguna dapat memahami cara kerja aplikasi ini, ya.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="{{ back()->getTargetUrl() }}" data-bs-toggle="tooltip"
                            data-bs-original-title="Kembali ke halaman sebelumnya."
                            class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                            Kembali
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
                                <a href="/dashboard/setting/guides">Panduan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Buat
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
                            <h3 class="card-title">Panduan Aplikasi</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/dashboard/setting/guides" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('nav_title'){{ 'is-invalid' }}@enderror">
                                                <label for="nav_title" class="form-label">Navbar Title</label>
                                                <div class="position-relative">
                                                    <input autofocus type="text" class="form-control py-2"
                                                        placeholder="e.g. Rekomendasi" id="nav_title" name="nav_title"
                                                        value="{{ old('nav_title') }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-card-heading py-2"></i>
                                                    </div>

                                                    @error('nav_title')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('title'){{ 'is-invalid' }}@enderror">
                                                <label for="title" class="form-label">Judul</label>
                                                <div class="position-relative">
                                                    <input autofocus type="text" class="form-control py-2"
                                                        placeholder="e.g. Berikut adalah rekomendasi ..." id="title"
                                                        name="title" value="{{ old('title') }}" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-card-heading py-2"></i>
                                                    </div>

                                                    @error('title')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div
                                                class="form-group has-icon-left mandatory @error('slug'){{ 'is-invalid' }}@enderror">
                                                <label for="slug" class="form-label">Slug</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control py-2"
                                                        placeholder="e.g. recommendation" id="slug" name="slug"
                                                        value="{{ old('slug') }}" autocomplete="off" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-pencil py-2"></i>
                                                    </div>

                                                    @error('slug')
                                                        <div class="invalid-feedback d-block">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-1">
                                            <div class="form-group mandatory">
                                                <label for="parent" class="form-label">Parent</label>
                                                <select class="choices form-select" id="parent" name="id_guide_parent">
                                                    <optgroup label="Lainnya">
                                                        <option value="0">Tanpa parent</option>
                                                    </optgroup>
                                                    <optgroup label="Parent">
                                                        @forelse ($guides as $guideApp)
                                                            <option @if (old('id_guide_parent') == $guideApp->slug) selected @endif
                                                                value="{{ $guideApp->slug }}">
                                                                @if ($guideApp->parent)
                                                                    {{ ucwords($guideApp->parent->nav_title) }} -
                                                                @endif {{ $guideApp->nav_title }}
                                                            </option>
                                                        @empty
                                                            <option>No category</option>
                                                        @endforelse
                                                    </optgroup>
                                                </select>

                                                @error('id_guide_parent')
                                                    <div class="invalid-feedback d-block" style="margin-top: -24px">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-1">
                                            <div class="form-group mandatory @error('status'){{ 'is-invalid' }}@enderror">
                                                <fieldset>
                                                    <label class="form-label">
                                                        Status
                                                    </label>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="status"
                                                                id="status-single" value="single"
                                                                @if (old('status') == 'single') checked @endif />
                                                            <label data-bs-toggle="tooltip"
                                                                data-bs-original-title="Status ini akan membuat guide tanpa single."
                                                                class="form-check-label form-label" for="status-single">
                                                                Tanpa child (single)
                                                            </label>
                                                        </div>
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="status"
                                                                id="status-parent" value="parent"
                                                                @if (old('status') == 'parent') checked @endif />
                                                            <label data-bs-toggle="tooltip"
                                                                data-bs-original-title="Status ini akan membuat guide memiliki child."
                                                                class="form-check-label form-label" for="status-parent">
                                                                Dengan child (parent)
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                @error('status')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <div class="form-group mandatory @error('body'){{ 'is-invalid' }}@enderror">
                                                <div class="position-relative">
                                                    <label class="form-label">Isi Panduan Aplikasi</label>

                                                    <input id="body" name="body" value="{{ old('body') }}"
                                                        type="hidden">
                                                    <div id="editor">
                                                        {!! old('body') !!}
                                                    </div>

                                                    @error('body')
                                                        <div class="invalid-feedback d-block">
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

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- Forget error alert config --}}
    @if (session()->has('alert') &&
            array_key_exists('config', session('alert')) &&
            json_decode(session('alert')['config'], true)['icon'] === 'error')
        {{ Session::forget('alert') }}
    @endif

    {{-- Quill --}}
    <script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
    @vite(['resources/js/quill/guide/guide.js'])
    {{-- Jquery --}}
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    {{-- Form: select option --}}
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    @vite(['resources/js/choices.js'])
    {{-- Sluggable --}}
    @vite(['resources/js/sluggable/guide/guide.js'])
@endsection
