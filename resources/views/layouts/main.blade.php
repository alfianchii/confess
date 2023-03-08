<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="overflow-x: hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} | {{ $title }}</title>

    @include('partials.link')

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <script src="{{ asset('assets/js/initTheme.js') }}"></script>

    <div id="app">
        @include('layouts.navbar')

        {{-- <div id="main" class="m-0 py-0"> --}}
        @yield('content')

        @include('layouts.footer')
    </div>

    @include('partials.script')
</body>

</html>
