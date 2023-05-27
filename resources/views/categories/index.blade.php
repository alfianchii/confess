@extends('layouts.main')

@section('content')
    <section class="container px-4">
        <div class="page-heading">
            <div class="page-title">
                <div class="row justify-content-center">
                    <div class="col-12 mb-3 header-about mt-3">
                        <div class="text-center mt-4 mt-sm-5">
                            <h2>Kategori Keluhan</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content">
            <div class="row">
                @forelse($categories as $category)
                    <div class="col-md-4 mb-3">
                        {{-- <div class="card">
                            <div class="position-absolute px-3 py-2 bg-nav">
                                <a class="text-white" href="/complaints?category={{ $category->slug }}">
                                    {{ $category->name }}
                                </a>
                            </div>

                            @if ($category->image)
                                <img class="img-fluid rounded" src="{{ asset("storage/$category->image") }}"
                                    alt="{{ $category->name }}">
                            @else
                                <img class="img-fluid rounded" src="{{ asset('images/no-image-2.jpg') }}"
                                    alt="{{ $category->name }}">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title d-inline-block">TEST</h5>

                                <hr>

                                <p class="card-text">test</p>

                                <div class="mt-4">
                                    <a class="btn btn-color text-white" href="/complaints/{{ $category->slug }}">
                                        Selengkapnya ...
                                    </a>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $category->title }}</h4>
                                    <p class="card-text">
                                        {{ $category->description }}
                                    </p>
                                </div>
                                <img class="img-fluid w-100" src="{{ asset('assets/compiled/jpg/banana.jpg') }}"
                                    alt="Card image cap">
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <button class="btn btn-light-primary">Cari ...</button>
                            </div>
                        </div> --}}

                        {{-- <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $category->name }}</h4>
                                    <div class="card-text mb-0">
                                        {!! $category->description !!}
                                    </div>
                                </div>
                                <img class="card-img-bottom img-fluid" src="{{ asset('assets/compiled/jpg/water.jpg') }}"
                                    alt="Card image cap" style="height: 20rem; object-fit: cover;">
                            </div>
                        </div> --}}

                        <div class="card">
                            <div class="card-content">
                                @if ($category->image)
                                    <img class="card-img-top img-fluid" src="{{ asset('storage/' . $category->image) }}"
                                        alt="{{ $category->name }}" style="height: 20rem" />
                                @else
                                    <img class="card-img-top img-fluid" src="{{ asset('images/no-image.jpg') }}"
                                        alt="{{ $category->name }}" style="height: 20rem" />
                                @endif
                                <div class="card-body">
                                    <h4 class="card-title">{{ $category->name }}</h4>

                                    <p class="card-text">
                                        {!! $category->description !!}
                                    </p>

                                    <div class="mt-4">
                                        <a href="/complaints?category={{ $category->slug }}"
                                            class="btn btn-color text-white block">Cari keluhan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="my-5">
                        <h3 class="text-center ">Tidak ada kategori :(</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
