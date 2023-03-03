<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name') }} | {{ $title }}</title>

    @include('partials.link')
</head>

<body>
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

                @include('layouts.footer')
            </div>
        </div>
    </div>

    @include('partials.script')
</body>

</html>
