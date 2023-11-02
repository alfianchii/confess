@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- Simple DataTable --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable.css') }}" />
    {{-- Sweetalert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Semua Kategori Pengakuan</h2>
                    <p class="text-subtitle text-muted">
                        Keseluruhan data dari kategori untuk pengakuan.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a data-bs-toggle="tooltip" data-bs-original-title="Buat sebuah kategori untuk suatu pengakuan."
                            href="/dashboard/confessions/confession-categories/create"
                            class="btn btn-success px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span> Buat Kategori
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Kategori
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3>Kategori Pengakuan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Jumlah Pengakuan</th>
                                <th>Sunting</th>
                                <th>Foto</th>
                                <th>Data</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($confessionCategories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td>{!! $category->description !!}</td>
                                    <td>{!! $category->confessions->count() !!}</td>
                                    <td>
                                        @if ($category->updated_by)
                                            <span class="badge bg-light-warning">Ya</span>
                                        @else
                                            <span class="badge bg-light-dark">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($category->image)
                                            <span class="badge bg-light-warning">Ya</span>
                                        @else
                                            <span class="badge bg-light-dark">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($category->flag_active === 'Y')
                                            <span class="badge bg-light-success">Active</span>
                                        @else
                                            <span class="badge bg-light-danger">Non-active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @if ($category->flag_active === 'Y')
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Lakukan penyuntingan terhadap kategori pengakuan."
                                                        href="/dashboard/confessions/confession-categories/{{ $category->slug }}/edit"
                                                        class="btn btn-warning px-2 pt-2">
                                                        <span class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Hapus kategori pengakuan." href="#"
                                                        class="btn btn-danger px-2 pt-2"
                                                        data-confirm-confession-category-destroy="true"
                                                        data-unique="{{ base64_encode($category->slug) }}">
                                                        <span data-confirm-confession-category-destroy="true"
                                                            data-unique="{{ base64_encode($category->slug) }}"
                                                            class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="me-2">
                                                    <a data-bs-toggle="tooltip"
                                                        data-bs-original-title="Aktivasi kategori pengakuan." href="#"
                                                        class="btn btn-success px-2 pt-2"
                                                        data-confirm-confession-category-activate="true"
                                                        data-unique="{{ base64_encode($category->slug) }}">
                                                        <span data-confirm-confession-category-activate="true"
                                                            data-unique="{{ base64_encode($category->slug) }}"
                                                            class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <p class="text-center mt-3">Tidak ada kategori pengakuan :(</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/confession/category/category.js'])
    {{-- Simple DataTable --}}
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    @vite(['resources/js/simple-datatable/confession/category/category.js'])
@endsection
