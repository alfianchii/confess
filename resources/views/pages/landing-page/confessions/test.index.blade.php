{{-- TESTING --}}
<div class="page-content">
    @if ($confessions->count())
        {{-- All --}}
        <div class="row">
            @foreach ($confessions as $confession)
                <div class="col-12 mb-3">
                    <div class="card">
                        {{-- Heading --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex flex-row px-4 pt-4">
                                    <a class="d-flex flex-row" href="{{ $confession->slug }}">
                                        <img class="rounded-circle"
                                            src="{{ asset('images/user-images/default-avatar.png') }}" alt="Avatar"
                                            width="24" height="24">

                                        <p></p>
                                    </a>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        {{-- Content --}}
                        <div class="row">
                            {{-- Main --}}
                            <div class="col-10">
                                <div class="card-body">
                                    <h3 class="card-title">{{ $confession->title }}</h3>
                                </div>
                            </div>
                            {{-- Image --}}
                            <div class="col-2"></div>
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





{{-- REAL --}}
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
