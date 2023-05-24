@extends('layouts.main')

@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-6 mb-3 header-about bg-home w-100 pb-5">
                <div class="container pt-2 pt-sm-5">
                    <div class="row d-flex align-items-center text-sm-start text-center">
                        <div class="col-md-6 col-12" style="z-index: 10">
                            <h1 class="text-white fw-bold">{!! config('web_config')['HERO_TEXT_HEADER'] !!}</h1>
                            <p class="text-white fs-4 pt-3 pt-sm-4 w-100 ">
                                {!! config('web_config')['HERO_TEXT_DESCRIPTION'] !!}
                            </p>
                        </div>
                        <div class="col text-center text-md-end mt-5 mt-sm-0">
                            <img src="{{ asset('images/cloud storage.png') }}" alt="illustrasi laptop" class="illust-home"
                                width="70%">
                        </div>
                    </div>
                    <div class="poligon d-none d-md-block"></div>
                </div>
            </div>
            <div class="col-12">
                @if (session()->has('success'))
                    <div class="alert bg alert-dismissible show fade mt-4">
                        {{ session('success') }}
                        <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
                <div class="container">
                    <div class="garis"></div>
                    <div class="row alur-lapor mt-5 d-flex text-center align-content-start">
                        <div class="col">
                            <div class="ellipse">
                                <img src="../images/icon/Edit Property.svg" alt="icon" width="32">
                            </div>
                            <h5 class="mt-2">Tulis Laporan</h5>
                            <p class="d-md-block d-none">Laporkan keluhan atau aspirasi anda dengan jelas dan lengkap</p>
                        </div>
                        <div class="col">
                            <div class="ellipse">
                                <img src="../images/icon/In Progress.svg" alt="icon" width="36">
                            </div>
                            <h5 class="mt-2">Proses Verifikasi</h5>
                            <p class="d-md-block d-none">Laporan Anda akan diverifikasi dan diteruskan </p>
                        </div>
                        <div class="col">
                            <div class="ellipse">
                                <img src="../images/icon/Messaging.svg" alt="icon" width="37">
                            </div>
                            <h5 class="mt-2">Tindak Lanjut</h5>
                            <p class="d-md-block d-none">Petugas akan memperlajari dan menindaklanjuti laporan Anda</p>
                        </div>
                        <div class="col">
                            <div class="ellipse">
                                <img src="../images/icon/Chat Bubble.svg" alt="icon" width="37">
                            </div>
                            <h5 class="mt-2">Dapat Tanggapan</h5>
                            <p class="d-md-block d-none">Laporan anda akan di tanggapi oleh petugas</p>
                        </div>
                        <div class="col">
                            <div class="ellipse">
                                <img src="../images/icon/Done.svg" alt="icon" width="37">
                            </div>
                            <h5 class="mt-2">Selesai</h5>
                            <p class="d-md-block d-none">Laporan Anda akan terus ditindaklanjuti hingga terselesaikan</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center mt-5">
                        @can('student')
                            <a href="/dashboard/complaints/create" class="btn btn-lapor rounded-3 fw-bold">Buat
                                Laporan</a>
                        @endcan
                        @guest
                            <a href="/login" class="btn btn-lapor rounded-3 fw-bold">Buat
                                Laporan</a>
                        @endguest
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 jumlah-lapor mt-5 text-center">
                        <h3 class="text-white mt-4 fs-2">Jumlah Laporan</h3><br>
                        <p class="text-white fw-bold fs-1 mt-2"> {{ $complaintsCount }} </p><br>
                        <p class="text-white fw-bold fs-3 ">#JANGANTAKUTLAPOR!</p>
                    </div>
                </div>
                <div class="container">
                    <div class="row my-5">
                        <div class="col-12 mb-5">
                            <h2 class="text-center">Keuntungan menggunakan {{ config('web_config')['WEB_TITLE'] }}</h2>
                        </div>
                        <div class="row card-keuntungan d-block d-md-flex justify-content-center text-center mx-auto">
                            <div class="col">
                                <div class="card ms-auto">
                                    <div class="card-body">
                                        <div class="ellipse">
                                            <img src="../images/icon/privasi.svg" alt="icon" width="36"
                                                class="icon-keuntungan">
                                        </div>
                                        <h5 class="my-3">Privasi terjaga</h5>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt, quasi totam
                                            veniam voluptate excepturi mollitia.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card mx-auto">
                                    <div class="card-body">
                                        <div class="ellipse">
                                            <img src="../images/icon/keamanan.svg" alt="icon" width="35"
                                                class="icon-keuntungan">
                                        </div>
                                        <h5 class="my-3">Melapor dengan aman</h5>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt, quasi totam
                                            veniam voluptate excepturi mollitia.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card me-auto">
                                    <div class="card-body">
                                        <div class="ellipse">
                                            <img src="../images/icon/tanggap.svg" alt="icon" width="36"
                                                class="icon-keuntungan">
                                        </div>
                                        <h5 class="my-3">Laporan ditanggapi</h5>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt, quasi totam
                                            veniam voluptate excepturi mollitia.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
