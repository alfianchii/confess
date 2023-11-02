@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />
@endsection

{{-- --------------------------------- Content --}}
@section('content')
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- SweetAlert --}}
    @vite(['resources/js/sweetalert/swalSingle.js'])
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
