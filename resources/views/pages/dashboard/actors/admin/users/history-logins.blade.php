@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- Simple DataTable --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/table-datatable.css') }}" />
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Semua Riwayat Log-in</h2>
                    <p class="text-subtitle text-muted">
                        Berikut adalah semua riwayat log-in yang pernah dilakukan oleh pengguna.
                    </p>
                    <hr>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard/users">Pengguna</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Riwayat Log-in
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h3>Riwayat Log-in</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Username</th>
                                <th>Attempt Result</th>
                                <th>Operating System</th>
                                <th>IP</th>
                                <th>User Agent</th>
                                <th>Browser</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($historyLogins as $login)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $login->created_at->format('j F Y, \a\t H.i') }}</td>
                                    <td>{{ $login->username }}</td>
                                    <td>{{ $login->attempt_result }}</td>
                                    <td>{{ $login->operating_system }}</td>
                                    <td>{{ $login->remote_address }}</td>
                                    <td>{{ $login->user_agent }}</td>
                                    <td>{{ $login->browser }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <p class="text-center mt-3">Tidak ada riwayat log-in :(</p>
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
    {{-- Simple DataTable --}}
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    @vite(['resources/js/simple-datatable/user/history-login/history-login.js'])
@endsection
