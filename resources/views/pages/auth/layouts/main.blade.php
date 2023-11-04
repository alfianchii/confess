<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="overflow-x: hidden">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') - {{ config('web_config')['TEXT_WEB_TITLE'] }}</title>
    {{-- Base styles --}}
    @include('pages.auth.partials.link')
    {{-- Additional styles --}}
    @yield('additional_links')
</head>

<body>
    <div class="row d-block d-sm-flex height">
        {{-- Base layouts --}}
        @yield('content')
    </div>

    {{-- Base scripts --}}
    @include('pages.landing-page.partials.script')
    {{-- Additional scripts --}}
    @yield('additional_scripts')
</body>

</html>
