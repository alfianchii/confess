<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} - {{ config('web_config')['WEB_TITLE'] }}</title>

    {{-- Base links --}}
    @include('dashboard.partials.link')
    {{-- Necessary links --}}
    @yield('links')
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>

    <div id="app">
        {{-- Sidebar --}}
        @include('dashboard.layouts.sidebar')

        <div id="main" class="layout-navbar navbar-fixed">
            <header class="mb-3">
                {{-- Navbar --}}
                @include('dashboard.layouts.navbar')
            </header>

            <div id="main-content" class="pb-0">
                @yield('content')
            </div>
            <div class="w-100">
                @include('dashboard.layouts.footer')
            </div>
        </div>
    </div>

    {{-- Base scripts --}}
    @include('dashboard.partials.script')
    {{-- Necessary scripts --}}
    @yield('scripts')
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
    {{-- Tooltip globally --}}
    @vite(['resources/js/tooltip/globalTooltip.js'])
</body>

</html>
