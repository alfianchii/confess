<footer class="mt-5 pt-5 bg text-center text-white">
    <div class="row mb-2 row-gap-4">
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="row">
                <div class="col-12">
                    <p class="fs-5 fw-semibold">Dikelola Oleh</p>
                </div>
                <div class="col-12">
                    <img class="w-25" src="{{ asset('images/' . config('web_config')['IMAGE_FOOTER']) }}"
                        alt="Footer Website">
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="row">
                <div class="col-12">
                    <p class="fs-5 fw-semibold">Media Sosial</p>
                </div>
                <div class="col-12 mt-md-4">
                    <a target="_blank" class="text-white" href="{{ config('web_config')['LINK_SOCMED_INSTAGRAM'] }}">
                        <i class="bi bi-instagram fs-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-3 mb-md-0">
            <div class="row">
                <div class="col-12">
                    <p class="fs-5 fw-semibold">Slogan</p>
                </div>
                <div class="col-12 mt-md-5">
                    <h4 class="fw-medium text-white">#BerceritaItuMelegakan</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <hr>
            <div class="py-4">
                <p>&copy; 2023 {{ config('web_config')['TEXT_WEB_TITLE'] }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
