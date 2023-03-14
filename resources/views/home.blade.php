@extends('layouts.main')

@section('content')
    <div class="page-content">
        <section class="row  ">
            <div class="col-6 mb-3 header-about bg-home w-100 pb-5">
                <div class="container pt-2 pt-sm-5">
                    <div class="row d-flex align-items-center text-center">
                        <div class="col-sm-6 col-12" style="z-index: 10">
                            <h1 class="text-white fw-bold">Sistem Pengaduan Online SMKN 4 Kota Tangerang</h1>
                            <p class="text-white fs-4 pt-3 pt-sm-4 w-100 ">Sampaikan Laporan/Kritik/Saran Anda
                                Pada
                                Website Kami,<br>
                                <span class="fw-bold pt-3">#JanganTakutMelapor!</span>
                            </p>
                        </div>
                        <div class="col text-center text-sm-end mt-5 mt-sm-0">
                            <img src="{{ asset('images/cloud storage.png') }}" alt="illustrasi laptop" class="illust-home"
                                width="70%">
                        </div>
                    </div>
                    <div class="poligon d-none d-sm-block"></div>
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
