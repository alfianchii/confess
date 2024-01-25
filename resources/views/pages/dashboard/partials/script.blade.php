<script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
<script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/compiled/js/app.js') }}"></script>
@if (Request::is('dashboard/user/account/password*'))
    @vite('resources/js/changepassword.js')
@endif

<script>
    window.userSession = @json([
        'session' => session('issued_time'),
    ]);

    const imageData = document.getElementsByTagName("img");
    for (const image of imageData)
        if (image.src.includes('data:image')) {
            image.style.width = '100%';
            image.classList.add('rounded');
        }
</script>
