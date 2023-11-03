{{-- Base styles --}}
{{-- If WEB_FAVICON didn't contains "/" --}}
<style>
    body {
        font-family: 'Inter', sans-serif;
    }
</style>
@if (!strpos(config('web_config')['WEB_LOGO_WHITE'], '/'))
    <link rel="shortcut icon" href="{{ asset('images/' . config('web_config')['WEB_FAVICON']) }}" type="image/x-icon" />
@else
    <link rel="shortcut icon" href="{{ asset('storage/' . config('web_config')['WEB_FAVICON']) }}" type="image/x-icon" />
@endif
<link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}" />
@vite('resources/css/app.css')