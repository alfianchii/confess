<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('web_config')['TEXT_WEB_TITLE'] }} | 500</title>

    @include('errors.partials.link')
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="{{ asset('assets/compiled/svg/error-500.svg') }}" alt="System Error" />
                    <h1 class="error-title">System Error</h1>
                    <p class="fs-5 text-gray-600">
                        The website is currently unaivailable. Try again later or contact the developer.
                    </p>
                    <a href="/" class="btn btn-lg btn-outline-primary mt-3">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
