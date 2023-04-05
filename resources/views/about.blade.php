@extends('layouts.main')

@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 mb-3 header-about bg-about">
                <div class="container text-center mt-2 mt-sm-5">
                    <h1 class="text-white">Apa itu confess?</h1>
                    <img src="{{ asset('images/about.png') }}" alt="about illustration" class="illust-about">
                </div>
            </div>

            <div class="col-12">
                <div class="container mt-4 text-center ">
                    <p class="fs-5 px-sm-5"> Confess merupakan tempat bagi kalian yang menjadi bagian siswa/i SMKN 4 Kota
                        Tangerang untuk memberi kritik, saran, ataupun Aspirasi kalian selama menjadi siswa/i di sekolah
                        ini. dengan dibuatnya aplikasi ini kami berharap kalian semua menjadi lebih berani dan terbuka
                        kepada sekolah untuk mengatasi permasalahan - permasalahan yang ada. </p>
                    <h2 class="mt-5 mb-4">
                        Kenapa diciptakan nya Confess?
                    </h2>
                    <p class="fs-5 px-sm-5">Karena kami melihat banyak sekali tindakan tindakan yang tidak mencerminkan
                        seorang siswa/i sekolah seperti pemalakan, pembulian, pencurian dan masih banyak lagi yang terjadi
                        di sekolah ini, dengan adanya Confess kami ingin membantu siswa/i yang menjadi korban untuk
                        melaporkan masalah ini ke guru ataupun staff yang ada di sekolah ini melalui Confess. Jadi kami bisa
                        sedikit demi sedikit memberantas tindakan tindakan seperti itu. Selain itu Confess juga bisa
                        digunakan sebagai wadah untuk kalian yang mempunyai ide ide kreatif yang dapat membangun
                        karakteristik SMKN 4 Kota Tangerang.
                    </p>

                    <div class="text-center">
                        <h2 class=" my-5">
                            Lokasi Kami
                        </h2>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.5768925963066!2d106.63556391455468!3d-6.187333395520691!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f929162547c7%3A0xbbf35137362e584d!2sSMK%20Negeri%204%20Kota%20Tangerang!5e0!3m2!1sid!2sid!4v1677921080826!5m2!1sid!2sid"
                            width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
