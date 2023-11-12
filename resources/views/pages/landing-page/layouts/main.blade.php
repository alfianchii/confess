<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="overflow-x: hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('web_config')['TEXT_WEB_TITLE'] }}</title>
    {{-- Base styles --}}
    @include('pages.landing-page.partials.link')
    {{-- Additional styles --}}
    @yield('additional_links')
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>

    <div id="app">
        {{-- Base layouts --}}
        @include('pages.landing-page.layouts.navbar')
        @yield('content')
        @include('pages.landing-page.layouts.footer')
    </div>

    {{-- Base scripts --}}
    @include('pages.landing-page.partials.script')
    {{-- Tooltip globally --}}
    @vite(['resources/js/tooltip/globalTooltip.js'])
    {{-- Additional scripts --}}
    @yield('additional_scripts')
</body>

</html>
