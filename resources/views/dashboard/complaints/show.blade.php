@extends('dashboard.layouts.main')

@section('links')
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />
@endsection

@section('content')
@endsection

@section('scripts')
    {{-- SweetAlert --}}
    @vite(['resources/js/sweetalert/swalSingle.js'])
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
