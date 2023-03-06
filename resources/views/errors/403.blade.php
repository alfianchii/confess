<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }} | 403</title>

    @include('errors.partials.link')
</head>

<body>
    <script src="{{ asset('assets/js/initTheme.js') }}"></script>
    <div id="error">
        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <img class="img-error" src="{{ asset('assets/images/samples/error-403.svg') }}" alt="Not Found" />
                    <h1 class="error-title">Forbidden</h1>
                    <p class="fs-5 text-gray-600">
                        You are unauthorized to see this page.
                    </p>
                    <a href="{{ url()->previous() }}" class="btn btn-lg btn-outline-primary mt-3">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
