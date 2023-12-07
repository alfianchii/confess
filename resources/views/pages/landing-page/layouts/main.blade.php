<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="overflow-x: hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('web_config')['TEXT_WEB_TITLE'] }}</title>

    @include('pages.landing-page.partials.link')
    @yield('additional_links')
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>

    <div id="app" style="overflow-x: hidden;">
        @include('pages.landing-page.layouts.navbar')
        @yield('content')
        @include('pages.landing-page.layouts.footer')
    </div>

    @include('pages.landing-page.partials.script')
    @vite(['resources/js/tooltip/globalTooltip.js'])
    @yield('additional_scripts')
</body>

</html>
