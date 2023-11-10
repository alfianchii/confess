{{-- Base scripts --}}
<script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
<script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/compiled/js/app.js') }}"></script>
@if (Request::is('dashboard/user/account/password*'))
    @vite('resources/js/changepassword.js')
@endif
