@extends('dashboard.layouts.main')

@section('links')
@endsection

@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Edit Kategori</h2>
                    <p class="text-subtitle text-muted">
                        Buatlah sebuah kategori untuk keluhan.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="/dashboard/categories" class="btn btn-secondary me-1"><span data-feather="arrow-left"></span>
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
                                <a href="/dashboard/categories">Categories</a>
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
                            <h3 class="card-title mb-0">Kategori</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="/dashboard/categories/{{ $category->slug }}" method="POST">
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
    {{-- Sluggable --}}
    @vite(['resources/js/sluggable/slug.js'])
@endsection
