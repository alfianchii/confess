@extends('pages.landing-page.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    <section class="container px-4">
        <div class="page-heading">
            <div class="page-title">
                <div class="row justify-content-center">
                    <div class="col-12 mb-3 header-about mt-3">
                        <h2>Pengakuan</h2>
                        <p class="text-subtitle text-muted">
                            Daftar seluruh pengakuan yang telah dibuat oleh siswa/i.
                        </p>
                        <hr>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form action="/confessions">
                                @if (request('user'))
                                    <input type="hidden" name="user" value="{{ request('user') }}">
                                @elseif(request('status'))
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                @elseif(request('privacy'))
                                    <input type="hidden" name="privacy" value="{{ request('privacy') }}">
                                @elseif(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif

                                <div class="input-group mb-3">
                                    <input type="text" name="search" class="form-control" placeholder="Cari ..."
                                        value="{{ request('search') }}">
                                    <button class="btn btn-color text-white" id="search-button"
                                        type="submit">Search</button>
                                </div>

                                {{-- Reset Filters --}}
                                @if (!empty(request()->all()))
                                    <div class="mb-3 text-center">
                                        <a class="btn btn-color text-white" href="{{ url()->current([]) }}">Reset
                                            Filters</a>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content">
            @if ($confessions->count())
                {{-- First --}}
                <div class="row">
                    <div class="col mb-3">
                        <div class="card">
                            @if ($confessions[0]->image)
                                <img class="img-fluid rounded" src="{{ asset('storage/' . $confessions[0]->image) }}"
                                    alt="{{ $confessions[0]->category->category_name }}">
                            @else
                                <img class="img-fluid rounded" src="{{ asset('images/no-image-2.jpg') }}"
                                    alt="{{ $confessions[0]->category->category_name }}">
                            @endif

                            <div class="card-body text-center">
                                <h3 class="card-title d-inline-block">{{ $confessions[0]->title }}</h3>
                                <a href="{{ url('/confessions?privacy=' . $confessions[0]->privacy) }}">
                                    <small>({{ $confessions[0]->privacy }})</small>
                                </a>
                                <p>
                                    <small class="text-muted">
                                        By

                                        @if ($confessions[0]->privacy == 'anonymous')
                                            <i>"rahasia"</i>
                                        @elseif($confessions[0]->privacy == 'public')
                                            <a href="/confessions?user={{ $confessions[0]->student->user->username }}">
                                                {{ $confessions[0]->student->user->full_name }}
                                            </a>
                                        @endif

                                        in

                                        <a href="/confessions?category={{ $confessions[0]->category->slug }}">
                                            {{ $confessions[0]->category->category_name }}
                                        </a>

                                        {{ $confessions[0]->created_at->diffForHumans() }}
                                    </small>
                                </p>

                                <div class="mb-4">
                                    <a href="{{ url('/confessions?status=' . $confessions[0]->status) }}">
                                        @if ($confessions[0]->status == 'unprocess')
                                            <span class="badge bg-light-danger">
                                                Belum diproses
                                            </span>
                                        @elseif ($confessions[0]->status == 'process')
                                            <span class="badge bg-light-info">
                                                Sedang diproses
                                            </span>
                                        @elseif ($confessions[0]->status == 'release')
                                            <span class="badge bg-light">
                                                Release
                                            </span>
                                        @elseif ($confessions[0]->status == 'close')
                                            <span class="badge bg-light-success">
                                                Selesai
                                            </span>
                                        @endif
                                    </a>
                                </div>

                                <hr>

                                <div class="mb-4">
                                    <p class="card-text">{{ $confessions[0]->excerpt }}</p>
                                </div>

                                <a class="btn btn-color text-white"
                                    href="/confessions/{{ $confessions[0]->slug }}/comments/create">
                                    Selengkapnya ...
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- All --}}
                <div class="row">
                    @foreach ($confessions->skip(1) as $confession)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="position-absolute px-3 py-2 bg-nav">
                                    <a class="text-white" href="/confessions?category={{ $confession->category->slug }}">
                                        {{ $confession->category->category_name }}
                                    </a>
                                </div>

                                @if ($confession->image)
                                    <img class="img-fluid rounded" src="{{ asset("storage/$confession->image") }}"
                                        alt="{{ $confession->category->category_name }}">
                                @else
                                    <img class="img-fluid rounded" src="{{ asset('images/no-image-2.jpg') }}"
                                        alt="{{ $confession->category->category_name }}">
                                @endif

                                <div class="card-body">
                                    <h5 class="card-title d-inline-block">{{ $confession->title }}</h5>
                                    <a href="{{ url('/confessions?privacy=' . $confession->privacy) }}">
                                        <small>({{ $confession->privacy }})</small>
                                    </a>
                                    <p>
                                        <small class="text-muted">By
                                            @if ($confession->privacy == 'anonymous')
                                                <i>"rahasia"</i>
                                            @else
                                                <a href="/confessions?user={{ $confession->student->user->username }}">
                                                    {{ $confession->student->user->full_name }}
                                                </a>
                                            @endif

                                            {{ $confession->created_at->diffForHumans() }}
                                        </small>
                                    </p>

                                    <div class="mb-4">
                                        <a href="{{ url('/confessions?status=' . $confession->status) }}">
                                            @if ($confession->status == 'unprocess')
                                                <span class="badge bg-light-danger">
                                                    Belum diproses
                                                </span>
                                            @elseif ($confession->status == 'process')
                                                <span class="badge bg-light-info">
                                                    Sedang diproses
                                                </span>
                                            @elseif ($confession->status == 'release')
                                                <span class="badge bg-light">
                                                    Release
                                                </span>
                                            @elseif ($confession->status == 'close')
                                                <span class="badge bg-light-success">
                                                    Selesai
                                                </span>
                                            @endif
                                        </a>
                                    </div>

                                    <hr>

                                    <p class="card-text">{{ $confession->excerpt }}</p>

                                    <div class="mt-4">
                                        <a class="btn btn-color text-white"
                                            href="/confessions/{{ $confession->slug }}/comments/create">
                                            Selengkapnya ...
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="my-5">
                    <h3 class="text-center ">Tidak ada pengakuan :(</h3>
                </div>
            @endif

            <div class="row">
                <div class="col d-flex justify-content-center" id="pagin-links">
                    {{ $confessions->links('vendor.pagination.bootstrap') }}
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- --------------------------------- Content --}}
@section('content')
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
@endsection
