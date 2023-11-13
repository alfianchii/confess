<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('web_config')['TEXT_WEB_TITLE'] }}</title>
    {{-- Base styles --}}
    @include('pages.dashboard.partials.link')
    {{-- Additional styles --}}
    @yield('additional_links')
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>

    <div id="app" style="overflow-x: hidden;">
        {{-- Base Sidebar --}}
        @include('pages.dashboard.layouts.sidebar')

        <div id="main" class="layout-navbar navbar-fixed">
            <header>
                {{-- Base Navbar --}}
                @include('pages.dashboard.layouts.navbar')
            </header>

            <div id="main-content" class="pb-0">
                {{-- Content --}}
                @yield('content')
            </div>
            {{-- Base Footer --}}
            @include('pages.dashboard.layouts.footer')
        </div>
    </div>

    {{-- Base scripts --}}
    @include('pages.dashboard.partials.script')
    {{-- User's credentials --}}
    <script>
        window.userSession = @json([
            'session' => session('issued_time'),
        ]);
    </script>
    {{-- Additional scripts --}}
    @yield('additional_scripts')
    {{-- Tooltip globally --}}
    @vite(['resources/js/tooltip/globalTooltip.js'])
</body>

</html>
