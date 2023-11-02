@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
@endsection

{{-- --------------------------------- Content --}}
@section('content')
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- Display password --}}
    @vite('resources/js/display-password/change-password.js')
@endsection
