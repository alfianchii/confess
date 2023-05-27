@extends('layouts.main')

@section('content')
    <section class="container px-4">
        <div class="page-heading">
            <div class="page-title">
                <div class="row justify-content-center">
                    <div class="col-12 mb-3 header-about mt-3">
                        <div class="text-center mt-4 mt-sm-5">
                            <h2>Keluhan</h2>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form class="mx-auto" action="/complaints">
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
                                <input type="text" name="search" class="form-control" placeholder="Search ..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-color text-white" id="search-button" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content">
            @if ($complaints->count())
                {{-- First --}}
                <div class="row">
                    <div class="col mb-3">
                        <div class="card mb-3">
                            @if ($complaints[0]->image)
                                <img class="img-fluid rounded" src="{{ asset('storage/' . $complaints[0]->image) }}"
                                    alt="{{ $complaints[0]->category->name }}">
                            @else
                                <img class="img-fluid rounded" src="{{ asset('images/no-image-2.jpg') }}"
                                    alt="{{ $complaints[0]->category->name }}">
                            @endif

                            <div class="card-body text-center">
                                <h3 class="card-title d-inline-block">{{ $complaints[0]->title }}</h3>
                                @if ($complaints[0]->privacy == 'public')
                                    <a href="/complaints?privacy=anyone">
                                        <small>({{ $complaints[0]->privacy }})</small>
                                    </a>
                                @elseif($complaints[0]->privacy == 'anonymous')
                                    <a href="/complaints?privacy=anon">
                                        <small>({{ $complaints[0]->privacy }})</small>
                                    </a>
                                @endif
                                <p>
                                    <small class="text-muted">
                                        By

                                        @if ($complaints[0]->privacy == 'anonymous')
                                            {{ str_repeat('*', strlen($complaints[0]->student->user->name)) }}
                                        @elseif($complaints[0]->privacy == 'public')
                                            <a href="/complaints?user={{ $complaints[0]->student->user->username }}">
                                                {{ $complaints[0]->student->user->name }}
                                            </a>
                                        @endif

                                        in

                                        <a href="/complaints?category={{ $complaints[0]->category->slug }}">
                                            {{ $complaints[0]->category->name }}
                                        </a>

                                        {{ $complaints[0]->created_at->diffForHumans() }}
                                    </small>
                                </p>

                                <div class="mb-4">
                                    @if ($complaints[0]->status == 0)
                                        <a href="/complaints?status=not">
                                            <span class="badge bg-danger">
                                                Belum diproses
                                            </span>
                                        </a>
                                    @elseif ($complaints[0]->status == 1)
                                        <a href="/complaints?status=proc">
                                            <span class="badge bg-secondary">
                                                Sedang diproses
                                            </span>
                                        </a>
                                    @elseif ($complaints[0]->status == 2)
                                        <a href="/complaints?status=done">
                                            <span class="badge bg-success">
                                                Selesai
                                            </span>
                                        </a>
                                    @endif
                                </div>

                                <hr>

                                <div class="mb-4">
                                    <p class="card-text">{{ $complaints[0]->excerpt }}</p>
                                </div>

                                <a class="btn btn-color text-white" href="/complaints/{{ $complaints[0]->slug }}">
                                    Selengkapnya ...
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- All --}}
                <div class="row">
                    @foreach ($complaints->skip(1) as $complaint)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="position-absolute px-3 py-2 bg-nav">
                                    <a class="text-white" href="/complaints?category={{ $complaint->category->slug }}">
                                        {{ $complaint->category->name }}
                                    </a>
                                </div>

                                @if ($complaint->image)
                                    <img class="img-fluid rounded" src="{{ asset("storage/$complaint->image") }}"
                                        alt="{{ $complaint->category->name }}">
                                @else
                                    <img class="img-fluid rounded" src="{{ asset('images/no-image-2.jpg') }}"
                                        alt="{{ $complaint->category->name }}">
                                @endif

                                <div class="card-body">
                                    <h5 class="card-title d-inline-block">{{ $complaint->title }}</h5>
                                    @if ($complaint->privacy == 'public')
                                        <a href="/complaints?privacy=anyone">
                                            <small>({{ $complaint->privacy }})</small>
                                        </a>
                                    @elseif($complaint->privacy == 'anonymous')
                                        <a href="/complaints?privacy=anon">
                                            <small>({{ $complaint->privacy }})</small>
                                        </a>
                                    @endif
                                    <p>
                                        <small class="text-muted">By
                                            @if ($complaint->privacy == 'anonymous')
                                                *******
                                            @else
                                                <a href="/complaints?user={{ $complaint->student->user->username }}">
                                                    {{ $complaint->student->user->name }}
                                                </a>
                                            @endif

                                            {{ $complaint->created_at->diffForHumans() }}
                                        </small>
                                    </p>

                                    <div class="mb-4">
                                        @if ($complaint->status == 0)
                                            <a href="/complaints?status=not">
                                                <span class="badge bg-danger">
                                                    Belum diproses
                                                </span>
                                            </a>
                                        @elseif ($complaint->status == 1)
                                            <a href="/complaints?status=proc">
                                                <span class="badge bg-secondary">
                                                    Sedang diproses
                                                </span>
                                            </a>
                                        @elseif ($complaint->status == 2)
                                            <a href="/complaints?status=done">
                                                <span class="badge bg-success">
                                                    Selesai
                                                </span>
                                            </a>
                                        @endif
                                    </div>

                                    <hr>

                                    <p class="card-text">{{ $complaint->excerpt }}</p>

                                    <div class="mt-4">
                                        <a class="btn btn-color text-white" href="/complaints/{{ $complaint->slug }}">
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
                    <h3 class="text-center ">Tidak ada keluhan :(</h3>
                </div>
            @endif

            <div class="row">
                <div class="col d-flex justify-content-center" id="pagin-links">
                    {{ $complaints->links('vendor.pagination.bootstrap') }}
                </div>
            </div>
        </div>
    </section>
@endsection
