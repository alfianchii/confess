<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="overflow-x: hidden">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $title }} - {{ config('web_config')['WEB_TITLE'] }}</title>

    @include('auth.partials.link')
</head>

<body>
    <div class="row d-block d-sm-flex height">
        @yield('content')
    </div>

    @include('partials.script')
</body>

</html>
