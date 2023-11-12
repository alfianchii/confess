<nav class="navbar navbar-expand-lg navbar-dark text-white fixed-top bg-nav"
    id="{{ Request::is('confessions*') || Request::is('categories') ? '' : 'navbar' }}">
    <div class="container" id="navCont">
        <a class=" text-muted logo" href="/">
            {{-- Default --}}
            @if (File::exists(public_path('images/' . config('web_config')['IMAGE_WEB_LOGO_WHITE'])))
                <img src="{{ asset('images/' . config('web_config')['IMAGE_WEB_LOGO_WHITE']) }}"
                    alt="Logo {{ config('web_config')['TEXT_WEB_TITLE'] }}">
            @else
                <img src="{{ asset('storage/' . config('web_config')['IMAGE_WEB_LOGO_WHITE']) }}"
                    alt="Logo {{ config('web_config')['TEXT_WEB_TITLE'] }}">
            @endif
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav ms-auto mb-2 mb-lg-0 d-block d-sm-flex">
                <li class="nav-item">
                    <a class="nav-link text-white {{ Request::is('/') ? 'border-bottom border-3 fw-bold' : '' }}"
                        href="/">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ Request::is('about') ? 'border-bottom border-3 fw-bold' : '' }}"
                        href="/about">Tentang</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link text-white {{ Request::is('confessions*') ? 'border-bottom border-3 fw-bold' : '' }}"
                            href="/confessions">Pengakuan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ Request::is('categories') ? 'border-bottom border-3 fw-bold' : '' }}"
                            href="/categories">Kategori</a>
                    </li>
                @endauth
            </ul>

            <ul class="nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false"> Hai,
                            {{ $userData->full_name }}!</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="/dashboard"><i class="bi bi-speedometer2 me-1"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-left me-1"></i>
                                        Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white {{ Request::is('login') ? 'border-bottom border-3 fw-bold' : '' }}"
                            href="/login">Masuk</a>
                    </li>
                @endguest

                {{-- Light/Dark mode --}}
                <li class="nav-item">
                    <div class="theme-toggle d-flex gap-1 align-items-center mt-2 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                            height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                            <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                    opacity=".3"></path>
                                <g transform="translate(-210 -1)">
                                    <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                    <circle cx="220.5" cy="11.5" r="4"></circle>
                                    <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <div class="form-check form-switch fs-6">
                            <input class="form-check-input me-0" type="checkbox" id="toggle-dark"
                                style="cursor: pointer" />
                            <label class="form-check-label"></label>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20"
                            preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                            </path>
                        </svg>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
