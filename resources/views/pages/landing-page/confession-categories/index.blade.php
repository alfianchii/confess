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
                        <h2>Kategori Pengakuan</h2>
                        <p class="text-subtitle text-muted">
                            Daftar seluruh kategori pengakuan.
                        </p>
                        <hr>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form action="/confessions/categories">
                                <div class="input-group mb-3">
                                    <input type="text" name="search" class="form-control" placeholder="e.g. Pemalakan"
                                        value="{{ request('search') }}">
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
            <div class="row">
                @forelse($confessionCategories as $category)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-content">
                                @if ($category->image)
                                    <img class="card-img-top img-fluid" src="{{ asset('storage/' . $category->image) }}"
                                        alt="{{ $category->category_name }}" style="height: 20rem" />
                                @else
                                    <img class="card-img-top img-fluid" src="{{ asset('images/no-image.jpg') }}"
                                        alt="{{ $category->category_name }}" style="height: 20rem" />
                                @endif
                                <div class="card-body">
                                    <h4 class="card-title">{{ $category->category_name }}</h4>

                                    <p class="card-text">
                                        {!! $category->description !!}
                                    </p>

                                    <div class="mt-4">
                                        <a href="/confessions?category={{ $category->slug }}"
                                            class="btn btn-color text-white block">Pengakuan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="my-5">
                        <h3 class="text-center ">Tidak ada kategori pengakuan :(</h3>
                    </div>
                @endforelse
            </div>

            <div class="row">
                <div class="col d-flex justify-content-center" id="pagin-links">
                    {{ $confessionCategories->links('vendor.pagination.bootstrap') }}
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
@endsection
