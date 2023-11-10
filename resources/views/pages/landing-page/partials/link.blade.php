{{-- Base styles --}}
{{-- Default --}}
@if (File::exists(public_path('images/' . config('web_config')['IMAGE_WEB_FAVICON'])))
    <link rel="shortcut icon" href="{{ asset('images/' . config('web_config')['IMAGE_WEB_FAVICON']) }}"
        type="image/x-icon" />
@else
    <link rel="shortcut icon" href="{{ asset('storage/' . config('web_config')['IMAGE_WEB_FAVICON']) }}"
        type="image/x-icon" />
@endif
<link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}" />
@vite('resources/css/app.css')
