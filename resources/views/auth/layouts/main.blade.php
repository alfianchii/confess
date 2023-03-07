<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="overflow-x: hidden">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ config('app.name') }} | {{ $title }}</title>

    @include('auth.partials.link')
</head>

<body>
    <div class="row d-block d-sm-flex height">
        @yield('content')
    </div>

    @include('partials.script')
    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @include('sweetalert::alert')
</body>

</html>
