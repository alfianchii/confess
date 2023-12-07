{{-- --------------------------------- Landing Page --}}
<script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
<script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/compiled/js/app.js') }}"></script>
<script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
@if (!Route::is('login'))
    @vite('resources/js/navbar.js')
@endif

{{-- --------------------------------- Auth Page --}}
@if (Route::is('login'))
    @vite('resources/js/display-password/login.js')
    @vite(['resources/js/tooltip/globalTooltip.js'])
@endif
