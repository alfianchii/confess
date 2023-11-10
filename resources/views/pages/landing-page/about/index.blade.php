@extends('pages.landing-page.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 mb-3 header-about bg-about">
                <div class="container text-center mt-2 mt-sm-5">
                    <h1 class="text-white">Apa Itu {{ config('web_config')['TEXT_WEB_TITLE'] }}?</h1>
                    <img src="{{ asset('images/about.png') }}" alt="about illustration" class="illust-about">
                </div>
            </div>

            <div class="col-12">
                <div class="container mt-4 text-center ">
                    <p class="fs-5 px-sm-5">
                        {{ config('web_config')['TEXT_WEB_TITLE'] }} adalah wadah khusus bagi kamu, siswa/i
                        {{ config('web_config')['TEXT_FOOTER_DASHBOARD'] }}, buat
                        berbagi pengakuan, laporan, kritik, saran, atau aspirasi selama berada di sekolah ini. Dengan
                        hadirnya aplikasi {{ config('web_config')['TEXT_WEB_TITLE'] }}, harapannya kamu jadi lebih berani
                        dan terbuka ketika berkomunikasi dengan
                        sekolah untuk menangani berbagai permasalahan yang mungkin ada.
                    </p>
                    <h2 class="mt-5 mb-4">
                        Kenapa Diciptakannya {{ config('web_config')['TEXT_WEB_TITLE'] }}?
                    </h2>
                    <p class="fs-5 px-sm-5">
                        Kami melihat banyak sekali tingkah laku di sekolah yang kurang menyenangkan, seperti pemalakan,
                        penindasan,
                        dan lain sebagainya. Maka dari itu, kami harap dengan adanya
                        {{ config('web_config')['TEXT_WEB_TITLE'] }}, akan
                        membantu
                        kamu yang menjadi korban untuk lapor ke
                        guru atau staff lewat {{ config('web_config')['TEXT_WEB_TITLE'] }}. Agar kita bisa bersama-sama
                        menghadang hal-hal seperti itu. {{ config('web_config')['TEXT_WEB_TITLE'] }} juga bisa menjadi
                        tempat buat kamu yang punya ide-ide
                        kreatif
                        untuk membangun karakteristik {{ config('web_config')['TEXT_FOOTER_DASHBOARD'] }} agar bisa
                        berkembang menjadi lebih baik lagi.
                    </p>

                    <div class="text-center">
                        <h2 class=" my-5">
                            Lokasi Kami
                        </h2>

                        {!! config('web_config')['TEXT_WEB_LOCATION'] !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
@endsection
