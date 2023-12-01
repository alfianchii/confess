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
                    <h2>Semua Komentar Kamu</h2>
                    <p class="text-subtitle text-muted">
                        Keseluruhan data dari komentar kamu.
                    </p>
                    <hr>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Komentar
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between" style="row-gap: 1rem;">
                        <h3>Komentar Kamu</h3>

                        <div class="dropdown dropdown-color-icon mb-3 d-flex justify-content-start">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="export"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fa-fw select-all fas me-1"></span> Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="export">
                                <form action="/dashboard/confessions/comments/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="your-comments">
                                    <input type="hidden" name="type" value="XLSX">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all far text-light"></span> Excel
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/comments/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="your-comments">
                                    <input type="hidden" name="type" value="CSV">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all fas text-light"></span> CSV
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/comments/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="your-comments">
                                    <input type="hidden" name="type" value="HTML">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all fab text-light"></span> HTML
                                    </button>
                                </form>

                                <form action="/dashboard/confessions/comments/export" method="POST">
                                    @csrf
                                    <input type="hidden" name="table" value="your-comments">
                                    <input type="hidden" name="type" value="MPDF">
                                    <button type="submit" class="dropdown-item">
                                        <span class="fa-fw select-all far text-light"></span> PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Komentar</th>
                                <th>Sunting</th>
                                <th>File</th>
                                <th>Privasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($yourComments as $comment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $comment->created_at->format('Y-m-d') }}</td>
                                    <td>{!! $comment->comment !!}</td>
                                    <td>
                                        @if ($comment->updated_by)
                                            <span class="badge bg-light-warning">Ya</span>
                                        @else
                                            <span class="badge bg-light-dark">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($comment->attachment_file)
                                            <span class="badge bg-light-warning">Ya</span>
                                        @else
                                            <span class="badge bg-light-dark">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($comment->privacy === 'public')
                                            <span class="badge bg-light-warning">Publik</span>
                                        @elseif ($comment->privacy === 'anonymous')
                                            <span class="badge bg-light-dark">Anon</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Lakukan penyuntingan terhadap komentar kamu."
                                                    href="/dashboard/comments/{{ base64_encode($comment->id_confession_comment) }}/edit"
                                                    class="btn btn-warning px-2 pt-2">
                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>

                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Unsend komentar yang sudah kamu berikan."
                                                    class="btn btn-danger px-2 pt-2"
                                                    data-confirm-confession-comment-destroy="true"
                                                    data-unique="{{ base64_encode($comment->id_confession_comment) }}"
                                                    data-redirect="{{ base64_encode($comment->confession->slug) }}">
                                                    <span data-confirm-confession-comment-destroy="true"
                                                        data-redirect="{{ base64_encode($comment->confession->slug) }}"
                                                        data-unique="{{ base64_encode($comment->id_confession_comment) }}"
                                                        class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>

                                            <div class="me-2">
                                                <a data-bs-toggle="tooltip"
                                                    data-bs-original-title="Rincian dari komentar kamu."
                                                    href="/confessions/{{ $comment->confession->slug }}/comments/create?comment={{ base64_encode($comment->id_confession_comment) }}&page={{ $comment->page }}"
                                                    class="btn btn-info px-2 pt-2">
                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <p class="text-center mt-3">Tidak ada komentar :(</p>
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
    @vite(['resources/js/sweetalert/confession/comment/comment.js'])
    {{-- Simple DataTable --}}
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    @vite(['resources/js/simple-datatable/confession/comment/comment.js'])
@endsection
