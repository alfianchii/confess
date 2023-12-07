<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="overflow-x: hidden">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') - {{ config('web_config')['TEXT_WEB_TITLE'] }}</title>

    @include('pages.auth.partials.link')
    @yield('additional_links')
</head>

<body style="overflow-x: hidden;">
    <div class="row height">
        @yield('content')
    </div>

    @include('pages.landing-page.partials.script')
    @yield('additional_scripts')
</body>

</html>
