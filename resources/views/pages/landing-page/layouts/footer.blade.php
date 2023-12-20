<footer class="mt-5 pt-5 bg text-center text-white">
    <div class="row mb-2 row-gap-4">
        <div class="col-12 col-lg-4 mb-3 mb-md-0">
            <div class="row">
                <div class="col-12">
                    <p class="fs-5 fw-semibold">Dikelola Oleh</p>
                </div>
                <div class="col-12">
                    {{-- Default --}}
                    @if (File::exists(public_path('images/' . config('web_config')['IMAGE_FOOTER'])))
                        <img class="w-25" src="{{ asset('images/' . config('web_config')['IMAGE_FOOTER']) }}"
                            alt="Footer Website">
                    @else
                        <img class="w-25" src="{{ asset('storage/' . config('web_config')['IMAGE_FOOTER']) }}"
                            alt="Footer Website">
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 mb-3 mb-md-0">
            <div class="row">
                <div class="col-12 d-none d-lg-block">
                    <p class="fs-5 fw-semibold">Media Sosial</p>
                </div>
                <div class="col-12 mt-md-4">
                    <a target="_blank" class="text-white" href="{{ config('web_config')['LINK_SOCMED_INSTAGRAM'] }}">
                        <i class="bi bi-instagram fs-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 mb-3 mb-md-0">
            <div class="row">
                <div class="col-12 d-none d-lg-block">
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
            <div class="pt-4">
                <p>&copy; 2023 {{ config('web_config')['TEXT_WEB_TITLE'] }}. All rights reserved.</p>
            </div>
            <div class="pb-4">
                <small class="text-subtitle">Created w/ <a class="text-white" href="https://github.com/zuramai/mazer"
                        target="_blank"><u>Mazer</u></a> <span class="text-danger"><i
                            class="bi bi-heart-fill icon-mid"></i></span></small>
            </div>
        </div>
    </div>
</footer>
