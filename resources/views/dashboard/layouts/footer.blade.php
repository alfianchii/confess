<footer class="my-5">
    <div class="container">
        <div class="row mx-auto w-100 pt-5 pb-4 d-sm-flex d-block text-muted justify-content-center">
            <div class="col-12 col-md-3 text-center text-md-start">
                <p class="fs-5">Dikelola oleh</p>
                <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                    {{-- If FOOTER_IMAGE_DASHBOARD didn't contains "/" --}}
                    @if (strpos(config('web_config')['FOOTER_IMAGE_DASHBOARD'], '/') === false)
                        <img src="{{ asset('images/' . config('web_config')['FOOTER_IMAGE_DASHBOARD']) }}"
                            class="logo-smk4" alt="Footer Website" width="100%">
                    @else
                        <img src="{{ asset('storage/' . config('web_config')['FOOTER_IMAGE_DASHBOARD']) }}"
                            class="logo-smk4" alt="Footer Website" width="100%">
                    @endif
                    <span class="ms-2">{{ config('web_config')['FOOTER_TEXT_DASHBOARD'] }}</span>
                </div>
            </div>
            <div class="col pt-5 text-center">
                <p class="fw-bold fs-3 pt-0 pb-4 pt-sm-4 pb-sm-0 hashtag">#JANGANTAKUTLAPOR!</p>
            </div>
            <div class="col-12 col-md-3 text-center">
                <p class="fs-5 sosial">
                    Sosial media kami
                </p>
                <div class="row">
                    <div class="col"><i class="bi bi-github fs-1"></i></div>
                    <div class="col"><i class="bi bi-github fs-1"></i></div>
                    <div class="col"><i class="bi bi-github fs-1"></i></div>
                </div>
            </div>
        </div>
        <div class="row mx-auto w-100">
            <div class="col-12 text-center">
                <p>Copyright © 2023 {{ config('web_config')['WEB_TITLE'] }}. All rights reserved</p>
            </div>
        </div>
    </div>
</footer>
