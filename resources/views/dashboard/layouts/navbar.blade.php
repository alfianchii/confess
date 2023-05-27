<nav class="navbar navbar-expand navbar-light navbar-top">
    <div class="container-fluid">
        <a href="#" class="burger-btn d-block">
            <i class="bi bi-justify fs-3"></i>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-lg-0" id="notif">
                {{-- <li class="nav-item dropdown me-1">
                    <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-envelope bi-sub fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 class="dropdown-header">Mail</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">No new mail</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown me-3">
                    <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown"
                        data-bs-display="static" aria-expanded="false">
                        <i class="bi bi-bell bi-sub fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-center dropdown-menu-md-end notification-dropdown"
                        aria-labelledby="dropdownMenuButton">
                        <li class="dropdown-header">
                            <h6>Notifikasi</h6>
                        </li>
                        <li class="dropdown-item notification-item">
                            <a class="d-flex align-items-center" href="#">
                                <div class="notification-icon bg-primary">
                                    <i class="bi bi-cart-check"></i>
                                </div>
                                <div class="notification-text ms-4">
                                    <p class="notification-title font-bold">
                                        Berhasil melakukan pembayaran
                                    </p>
                                    <p class="notification-subtitle font-thin text-sm">
                                        ID Pesanan #256
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-item notification-item">
                            <a class="d-flex align-items-center" href="#">
                                <div class="notification-icon bg-success">
                                    <i class="bi bi-file-earmark-check"></i>
                                </div>
                                <div class="notification-text ms-4">
                                    <p class="notification-title font-bold">
                                        Pekerjaan rumah telah dikirim
                                    </p>
                                    <p class="notification-subtitle font-thin text-sm">
                                        Matematika Aljabar
                                    </p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <p class="text-center py-2 mb-0">
                                <a href="#">See all notification</a>
                            </p>
                        </li>
                    </ul>
                </li> --}}
            </ul>
            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-name text-end me-3">
                            <h6 class="mb-0 text-gray-600">{{ ucwords(auth()->user()->name) }}</h6>
                            <p class="mb-0 text-sm text-gray-600">{{ ucwords(auth()->user()->level) }}</p>
                        </div>
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                @if (auth()->user()->image)
                                    <img src="{{ asset('storage') . '/' . auth()->user()->image }}" />
                                @else
                                    <img src="{{ asset('assets/static/images/faces/1.jpg') }}" />
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                    style="min-width: 11rem">
                    <li>
                        <h6 class="dropdown-header">Halo, {{ auth()->user()->username }}!</h6>
                    </li>
                    <li>
                        <a class="dropdown-item @if (Request::is('dashboard/user/account/profile*')) active @endif"
                            href="/dashboard/user/account/profile"><i class="icon-mid bi bi-person me-2"></i> Profil
                            Saya</a>
                    </li>
                    <li>
                        <a class="dropdown-item @if (Request::is('dashboard/user/account/setting*')) active @endif"
                            href="/dashboard/user/account/setting"><i class="icon-mid bi bi-gear me-2"></i>
                            Pengaturan Akun</a>
                    </li>
                    <li>
                        <a class="dropdown-item @if (Request::is('dashboard/user/account/password*')) active @endif"
                            href="/dashboard/user/account/password"><i class="icon-mid bi bi-key me-2"></i>
                            Password</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item"><i
                                    class="icon-mid bi bi-box-arrow-left me-2"></i> Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
