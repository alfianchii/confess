<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('web_config')['TEXT_WEB_TITLE'] }}</title>

    @include('pages.dashboard.partials.link')
    @yield('additional_links')
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>

    <div id="app" style="overflow-x: hidden;">
        @include('pages.dashboard.layouts.sidebar')

        <div id="main" class="layout-navbar navbar-fixed">
            <header>
                @include('pages.dashboard.layouts.navbar')
            </header>

            <div id="main-content" class="pb-0">
                @yield('content')
            </div>

            @include('pages.dashboard.layouts.footer')
        </div>
    </div>

    @include('pages.dashboard.partials.script')
    @yield('additional_scripts')
    @vite(['resources/js/tooltip/globalTooltip.js'])
</body>

</html>
