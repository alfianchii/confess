@extends('layouts.main')

@section('content')
    <div class="page-content">
        <section class="row  ">
            <div class="col-6 mb-3 header-about bg-home">
                <div class="container pt-5">
                    <div class="row  d-flex align-items-center">
                        <div class="col-6">
                            <h1 class="text-white fw-bold">Pengaduan Online <br>SMKN 4 Kota Tangerang</h1>
                            <p class="text-white fs-4 pt-3">Sampaikan Laporan Anda Pada Website Kami,<br>
                                Jangan Takut Melapor!
                            </p>
                        </div>
                        <div class="col text-end">
                            <img src="{{ asset('images/cloud storage.png') }}" alt="illustrasi laptop" class="illust-home"
                                width="70%">
                        </div>
                    </div>
                    <div class="poligon"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="container">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible show fade mt-4">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Id sequi quidem cumque iusto
                        laborum alias ut modi minima expedita sed? Natus earum ipsum, iusto veritatis quidem
                        pariatur soluta cum dolore, quis mollitia dolorem neque debitis quisquam illo sint omnis
                        atque labore voluptates ex odio obcaecati saepe optio repellendus? Quas dicta porro
                        sapiente
                        labore repellendus praesentium suscipit tempora, velit quaerat aut aperiam perferendis
                        eveniet? Quisquam reprehenderit hic earum dolore ullam reiciendis. Voluptatem labore
                        aperiam
                        quidem incidunt dignissimos iusto inventore voluptatibus quia nihil nemo error
                        repellendus,
                        dolorem necessitatibus ipsa unde voluptates perferendis optio, impedit officia ipsam
                        dolorum. Amet nihil quisquam ab ipsam!</p>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Id sequi quidem cumque iusto
                        laborum alias ut modi minima expedita sed? Natus earum ipsum, iusto veritatis quidem
                        pariatur soluta cum dolore, quis mollitia dolorem neque debitis quisquam illo sint omnis
                        atque labore voluptates ex odio obcaecati saepe optio repellendus? Quas dicta porro
                        sapiente
                        labore repellendus praesentium suscipit tempora, velit quaerat aut aperiam perferendis
                        eveniet? Quisquam reprehenderit hic earum dolore ullam reiciendis. Voluptatem labore
                        aperiam
                        quidem incidunt dignissimos iusto inventore voluptatibus quia nihil nemo error
                        repellendus,
                        dolorem necessitatibus ipsa unde voluptates perferendis optio, impedit officia ipsam
                        dolorum. Amet nihil quisquam ab ipsam!</p>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Id sequi quidem cumque iusto
                        laborum alias ut modi minima expedita sed? Natus earum ipsum, iusto veritatis quidem
                        pariatur soluta cum dolore, quis mollitia dolorem neque debitis quisquam illo sint omnis
                        atque labore voluptates ex odio obcaecati saepe optio repellendus? Quas dicta porro
                        sapiente
                        labore repellendus praesentium suscipit tempora, velit quaerat aut aperiam perferendis
                        eveniet? Quisquam reprehenderit hic earum dolore ullam reiciendis. Voluptatem labore
                        aperiam
                        quidem incidunt dignissimos iusto inventore voluptatibus quia nihil nemo error
                        repellendus,
                        dolorem necessitatibus ipsa unde voluptates perferendis optio, impedit officia ipsam
                        dolorum. Amet nihil quisquam ab ipsam!</p>
                </div>
            </div>
        </section>
    </div>
@endsection
