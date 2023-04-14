@extends('layouts.main')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row justify-content-center">
                <div class="col-12 mb-3 header-about">
                    <div class="container text-center mt-2 mt-sm-5">
                        <h1 class="">Keluhan</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <form class="mx-auto" action="/complaints">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @elseif(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @elseif(request('privacy'))
                            <input type="hidden" name="privacy" value="{{ request('privacy') }}">
                        @endif

                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Search ..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" id="search-button" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            @if ($complaints->count())
                {{-- First --}}
                <div class="card mb-3">
                    @if ($complaints[0]->image)
                        <div style="max-height: 400px; overflow: hidden;">
                            <img class="img-fluid rounded" src="{{ asset('storage/' . $complaints[0]->image) }}"
                                alt="{{ $complaints[0]->category->name }}">
                        </div>
                    @else
                        <img class="img-fluid rounded" src="{{ asset('images/no-image-2.jpg') }}"
                            alt="{{ $complaints[0]->category->name }}">
                    @endif

                    <div class="card-body text-center">
                        <h3 class="card-title"><a
                                href="/complaints/{{ $complaints[0]->slug }}">{{ $complaints[0]->title }}</a>
                        </h3>
                        <p>
                            <small class="text-muted">By
                                @if ($complaints[0]->privacy == 'anonymous')
                                    *******
                                @else
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

                        <p class="card-text">{{ $complaints[0]->excerpt }}</p>

                        <a class="btn btn-primary" href="/complaints/{{ $complaints[0]->slug }}">Read
                            More</a>
                    </div>
                </div>

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
                                    <h5 class="card-title">{{ $complaint->title }}</h5>
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

                                    <p class="card-text">{{ $complaint->excerpt }}</p>

                                    <a class="btn btn-primary" href="/complaints/{{ $complaint->slug }}">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center fs-4 text-warning">Tidak ada keluhan!</p>
            @endif

            <div class="row">
                <div class="col d-flex justify-content-center">
                    {{ $complaints->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
