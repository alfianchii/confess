@extends('pages.landing-page.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
@endsection

{{-- --------------------------------- Content --}}
@section('content')
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

                    <div class="row justify-content-start">
                        <div class="col-12">
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
                                    <input type="text" name="search" class="form-control"
                                        placeholder="e.g. Kemarin siang aku ..." value="{{ request('search') }}">
                                    <button class="btn btn-color text-white" id="search-button" type="submit">Cari</button>
                                </div>

                                {{-- Reset Filters --}}
                                {{-- If just "page" on params, don't display --}}
                                @if (count(request()->all()) === 1 && array_key_exists('page', request()->all()))
                                    <div class="mb-3 text-center d-none">
                                        <a class="btn btn-color text-white">Tidak ada filters :(</a>
                                    </div>
                                @elseif (!empty(request()->all()))
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
            {{-- All --}}
            <div class="row">
                @forelse($confessions as $confession)
                    <div class="col-12">
                        <div class="card mb-3 shadow-sm">
                            {{-- Heading --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex flex-row px-4 pt-4">
                                        {{-- Image --}}
                                        <div style="margin-right: 12px;">
                                            @if ($confession->privacy === 'anonymous')
                                                <img class="rounded-circle" width="48" height="48"
                                                    src="{{ asset('images/user-images/default-avatar.png') }}"
                                                    alt="User Avatar" />
                                            @else
                                                <a href="/users/{{ $confession->student->user->username }}">
                                                    @if ($isUserImageExist($confession->student->user->profile_picture))
                                                        @if (File::exists(public_path('images/' . $confession->student->user->profile_picture)))
                                                            <img class="rounded-circle" width="48" height="48"
                                                                style="cursor: pointer;"
                                                                onclick="window.location.href='/users/{{ $confession->student->user->username }}'"
                                                                src="{{ asset('images/' . $confession->student->user->profile_picture) }}"
                                                                alt="User Avatar" />
                                                        @else
                                                            <img class="rounded-circle" width="48" height="48"
                                                                style="cursor: pointer;"
                                                                onclick="window.location.href='/users/{{ $confession->student->user->username }}'"
                                                                src="{{ asset('storage/' . $confession->student->user->profile_picture) }}"
                                                                alt="User Avatar" />
                                                        @endif
                                                    @else
                                                        @if ($confession->student->user->gender === 'L')
                                                            <img class="rounded-circle" width="48" height="48"
                                                                style="cursor: pointer;"
                                                                onclick="window.location.href='/users/{{ $confession->student->user->username }}'"
                                                                src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                                alt="User Avatar" />
                                                        @else
                                                            <img class="rounded-circle" width="48" height="48"
                                                                style="cursor: pointer;"
                                                                onclick="window.location.href='/users/{{ $confession->student->user->username }}'"
                                                                src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                                alt="User Avatar" />
                                                        @endif
                                                    @endif
                                                </a>
                                            @endif
                                        </div>

                                        {{-- Text --}}
                                        <div class="d-flex justify-content-start flex-column">
                                            <span class="fw-semibold">
                                                @if ($confession->privacy == 'anonymous')
                                                    <i>Rahasia</i> 🤫
                                                @else
                                                    <a href="/confessions?user={{ $confession->student->user->username }}">
                                                        {{ $confession->student->user->full_name }}
                                                    </a>
                                                @endif
                                            </span>

                                            <span class="fw-normal text-muted">
                                                <p class="mb-0" style="font-size: 0.875rem">
                                                    {{ $confession->created_at->diffForHumans() }}</p>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="row ms-md-5">
                                {{-- Main --}}
                                <div class="col-12">
                                    <div class="card-body pt-3">
                                        <a href="/confessions/{{ $confession->slug }}/comments/create"
                                            class="text-reset d-block">
                                            <h5 class="card-title">{{ $confession->title }}</h5>
                                            <p class="card-text">{{ $confession->excerpt }}</p>
                                        </a>

                                        {{-- Footer --}}
                                        <div
                                            class="d-flex flex-md-row flex-column-reverse justify-content-between mt-3 row-gap-4">
                                            <div class="btn-group align-items-center column-gap-4">
                                                <div>
                                                    <form action="/confessions/{{ $confession->slug }}/like-dislike"
                                                        method="POST">
                                                        <button type="submit"
                                                            class="btn btn-link text-decoration-none p-0 d-flex align-items-center text-reset">
                                                            <i
                                                                class="bi @if ($confession->is_liked) {{ 'bi-heart-fill' }} @else {{ 'bi-heart' }} @endif d-flex align-items-center justify-content-center text-secondary me-2"></i>
                                                            <span class="me-1">{{ $confession->likes->count() }}</span>
                                                            <span class="d-none d-sm-inline">suka</span>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div>
                                                    <a href="/confessions/{{ $confession->slug }}/comments/create?scroll-to=comments"
                                                        class="btn btn-link text-decoration-none p-0 d-flex align-items-center text-reset">
                                                        <i
                                                            class="bi bi-chat d-flex align-items-center justify-content-center text-secondary me-2"></i>
                                                        <span class="me-1">{{ $confession->comments->count() }}</span>
                                                        <span class="d-none d-sm-inline">komentar</span>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="d-flex column-gap-3">
                                                <a class="badge btn-color"
                                                    href="/confessions?category={{ $confession->category->slug }}">
                                                    {{ $confession->category->category_name }}
                                                </a>

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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="my-5">
                        <h3 class="text-center ">Tidak ada pengakuan :(</h3>
                    </div>
                @endforelse
            </div>

            <div class="row mt-4">
                <div class="col d-flex justify-content-center" id="pagin-links">
                    {{ $confessions->links('vendor.pagination.bootstrap') }}
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
@endsection
