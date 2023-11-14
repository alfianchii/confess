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
            </ul>
            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-name text-end me-3">
                            <h6 class="mb-0 text-gray-600">{{ $userData->full_name }}</h6>
                            <p class="mb-0 text-sm text-gray-600">{{ ucwords($userRole->role_name) }}</p>
                        </div>
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                @if ($isUserImageExist($userData->profile_picture))
                                    @if (File::exists(public_path('images/' . $userData->profile_picture)))
                                        <img src="{{ asset('images/' . $userData->profile_picture) }}"
                                            alt="User Avatar" />
                                    @else
                                        <img src="{{ asset('storage/' . $userData->profile_picture) }}"
                                            alt="User Avatar" />
                                    @endif
                                @else
                                    @if ($userData->gender === 'L')
                                        <img src="{{ asset('assets/static/images/faces/2.jpg') }}" alt="User Avatar" />
                                    @else
                                        <img src="{{ asset('assets/static/images/faces/5.jpg') }}" alt="User Avatar" />
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                    style="min-width: 11rem">
                    <li>
                        <h6 class="dropdown-header">Halo, {{ $userData->username }}!</h6>
                    </li>
                    <li>
                        <a class="dropdown-item @if (Request::is('dashboard/users/account')) active @endif"
                            href="/dashboard/users/account"><i class="icon-mid bi bi-person me-2"></i>
                            Profil Kamu</a>
                    </li>
                    <li>
                        <a class="dropdown-item @if (Request::is('dashboard/users/account/settings*')) active @endif"
                            href="/dashboard/users/account/settings"><i class="icon-mid bi bi-gear me-2"></i>
                            Pengaturan Akun</a>
                    </li>
                    <li>
                        <a class="dropdown-item @if (Request::is('dashboard/users/account/password*')) active @endif"
                            href="/dashboard/users/account/password"><i class="icon-mid bi bi-key me-2"></i>
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
