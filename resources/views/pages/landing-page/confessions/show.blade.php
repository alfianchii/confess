@extends('layouts.main')

@section('content')
    <section class="container px-5">
        <div class="page-heading">
            <div class="page-title">
                <div class="row justify-content-center">
                    <div class="col-12 mb-3 header-about mt-3">
                        <div class="text-center mt-4 mt-sm-5">
                            <h2 class="mb-4">
                                @if ($complaint->privacy == 'anonymous')
                                    Keluhan dari
                                    {{ htmlspecialchars('@' . str_repeat('*', strlen($complaint->student->user->username))) }}
                                @elseif($complaint->privacy == 'public')
                                    Keluhan dari
                                    {{ htmlspecialchars('@' . $complaint->student->user->username) }}
                                @endif
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mb-5">
                    <div class="col-12 col-md-10 shadow p-0">
                        {{-- Complaint --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title d-inline-block">{{ $complaint->title }}</h3>
                                @if ($complaint->privacy == 'public')
                                    <a href="/complaints?privacy=anyone">
                                        <small>({{ $complaint->privacy }})</small>
                                    </a>
                                @elseif($complaint->privacy == 'anonymous')
                                    <a href="/complaints?privacy=anon">
                                        <small>({{ $complaint->privacy }})</small>
                                    </a>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="me-4">
                                        <p>
                                            <span class="fw-bold">Tanggal:</span> {{ $complaint->date }}
                                        </p>
                                        <p>
                                            <span class="fw-bold">Tempat kejadian:</span>
                                            @if ($complaint->place == 'in')
                                                Dalam Sekolah
                                            @elseif ($complaint->place == 'out')
                                                Luar Sekolah
                                            @endif
                                        </p>
                                    </div>
                                    <div class="me-4">
                                        <p>
                                            <span class="fw-bold">Kategori:</span>
                                            <a href="/complaints?category={{ $complaint->category->slug }}"
                                                class="text-decoration-none">{{ $complaint->category->name }}
                                            </a>
                                        </p>
                                        <p>
                                            <span class="fw-bold me-1">Status:</span>
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
                                        </p>
                                    </div>
                                </div>

                                <hr>

                                <div class="px-5 py-3 d-flex justify-content-center">
                                    <a href="#">
                                        @if ($complaint->image)
                                            <img class="img-fluid rounded" data-bs-toggle="modal"
                                                data-bs-target="#imageDetail" src="{{ asset("storage/$complaint->image") }}"
                                                alt="{{ $complaint->category->name }}">
                                        @else
                                            <img class="img-fluid rounded" src="{{ asset('images/no-image-2.jpg') }}"
                                                alt="{{ $complaint->category->name }}" data-bs-toggle="modal"
                                                data-bs-target="#imageDetail">
                                        @endif
                                    </a>

                                    {{-- Modal --}}
                                    <div class="modal fade text-left" id="imageDetail" tabindex="-1"
                                        aria-labelledby="myModalLabel17" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel17">
                                                        Foto
                                                    </h4>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-x">
                                                            <line x1="18" y1="6" x2="6"
                                                                y2="18">
                                                            </line>
                                                            <line x1="6" y1="6" x2="18"
                                                                y2="18">
                                                            </line>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="d-flex justify-content-center">
                                                        @if ($complaint->image)
                                                            <img class="img-fluid rounded" data-bs-toggle="modal"
                                                                data-bs-target="#imageDetail"
                                                                src="{{ asset("storage/$complaint->image") }}"
                                                                alt="{{ $complaint->category->name }}">
                                                        @else
                                                            <img class="img-fluid rounded" data-bs-toggle="modal"
                                                                data-bs-target="#imageDetail"
                                                                src="{{ asset('images/no-image-2.jpg') }}"
                                                                alt="{{ $complaint->category->name }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="bx bx-x d-none"></i>
                                                        <span class="d-block">Close</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p>
                                    {!! $complaint->body !!}
                                </p>

                                <div class="my-2">
                                    <a href="/complaints" class="btn btn-color text-white mt-3">Kembali ke Keluhan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12 col-md-10">
                        {{-- Responses --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tanggapan</h3>
                            </div>
                            <div class="card-body">
                                @forelse ($complaint->responses as $response)
                                    <div class="row g-0 px-4 mt-5 mb-4 pb-2">
                                        <div class="col-md-2 d-flex align-items-start">
                                            @if ($isUserImageExist($response->profile_picture))
                                                @if (File::exists(public_path('images/' . $response->profile_picture)))
                                                    <img width="200" class="img-fluid rounded-circle mx-auto"
                                                        src="{{ asset('images/' . $response->profile_picture) }}"
                                                        alt="User Avatar" />
                                                @else
                                                    <img width="200" class="img-fluid rounded-circle mx-auto"
                                                        src="{{ asset('storage/' . $response->profile_picture) }}"
                                                        alt="User Avatar" />
                                                @endif
                                            @else
                                                @if ($response->gender === 'L')
                                                    <img width="200" class="img-fluid rounded-circle mx-auto"
                                                        src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                        alt="User Avatar" />
                                                @else
                                                    <img width="200" class="img-fluid rounded-circle mx-auto"
                                                        src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                        alt="User Avatar" />
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-md-10">
                                            <div class="card-body">
                                                <div class="text-md-start text-center">
                                                    <h4 class="card-title">{{ $response->officer->user->name }}</h4>
                                                    <small class="card-subtitle mb-2 text-muted">
                                                        {{ $response->created_at->diffForHumans() }}
                                                    </small>
                                                    <p class="card-text">{!! $response->body !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @empty
                                    <div class="alert alert-warning" role="alert">
                                        <h4 class="alert-heading">Tidak ada tanggapan :(</h4>
                                        <p>Belum ada tanggapan dari pihak terkait.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content">
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">

                </div>
            </div>
        </div>
    </section>
@endsection
