@extends('layouts.main')

@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 mb-3 header-about bg-about">
                <div class="container text-center mt-2 mt-sm-5">
                    <h1 class="text-white">Apa Itu {{ config('web_config')['WEB_TITLE'] }}?</h1>
                    <img src="{{ asset('images/about.png') }}" alt="about illustration" class="illust-about">
                </div>
            </div>

            <div class="col-12">
                <div class="container mt-4 text-center ">
                    <p class="fs-5 px-sm-5"> {{ config('web_config')['WEB_TITLE'] }} merupakan tempat bagi kamu yang menjadi
                        bagian siswa/i {{ config('web_config')['FOOTER_TEXT_DASHBOARD'] }} untuk memberi kritik, saran,
                        ataupun aspirasi selama menjadi siswa/i di sekolah ini. Dengan dibuatnya aplikasi
                        {{ config('web_config')['WEB_TITLE'] }}, kami berharap
                        bahwa kamu akan menjadi lebih berani dan terbuka kepada sekolah untuk mengatasi
                        permasalahan-permasalahan yang ada. </p>
                    <h2 class="mt-5 mb-4">
                        Kenapa Diciptakannya {{ config('web_config')['WEB_TITLE'] }}?
                    </h2>
                    <p class="fs-5 px-sm-5">Karena kami melihat banyak sekali tindakan-tindakan yang tidak mencerminkan
                        seorang siswa/i sekolah seperti pemalakan, pembulian, pencurian dan masih banyak lagi yang terjadi
                        di sekolah ini, dengan adanya {{ config('web_config')['WEB_TITLE'] }} kami ingin membantu siswa/i
                        yang menjadi korban untuk melaporkan masalah ini ke guru ataupun staff yang ada di sekolah ini
                        melalui
                        {{ config('web_config')['WEB_TITLE'] }}. Jadi kami bisa
                        sedikit demi sedikit memberantas tindakan-tindakan seperti itu. Selain itu
                        {{ config('web_config')['WEB_TITLE'] }} juga bisa
                        digunakan sebagai wadah untuk kamu yang mempunyai ide-ide kreatif yang dapat membangun
                        karakteristik {{ config('web_config')['FOOTER_TEXT_DASHBOARD'] }}.
                    </p>

                    <div class="text-center">
                        <h2 class=" my-5">
                            Lokasi Kami
                        </h2>

                        {!! config('web_config')['WEB_LOCATION'] !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
