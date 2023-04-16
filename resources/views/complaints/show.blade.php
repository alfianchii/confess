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

                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 p-0 shadow">
                        <div class="card mb-0">
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
                                                        <i class="bx bx-x d-block d-sm-none"></i>
                                                        <span class="d-none d-sm-block">Close</span>
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
