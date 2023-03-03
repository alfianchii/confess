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
            <ul class="navbar-nav ms-auto mb-lg-0">
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
                </li> --}}
                <li class="nav-item dropdown me-3">
                    <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown"
                        data-bs-display="static" aria-expanded="false">
                        <i class="bi bi-bell bi-sub fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown"
                        aria-labelledby="dropdownMenuButton">
                        <li class="dropdown-header">
                            <h6>Notifications</h6>
                        </li>
                        <li class="dropdown-item notification-item">
                            <a class="d-flex align-items-center" href="#">
                                <div class="notification-icon bg-primary">
                                    <i class="bi bi-cart-check"></i>
                                </div>
                                <div class="notification-text ms-4">
                                    <p class="notification-title font-bold">
                                        Successfully check out
                                    </p>
                                    <p class="notification-subtitle font-thin text-sm">
                                        Order ID #256
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
                                        Homework submitted
                                    </p>
                                    <p class="notification-subtitle font-thin text-sm">
                                        Algebra math homework
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
                </li>
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
                                <img src="assets/images/faces/1.jpg" />
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                    style="min-width: 11rem">
                    <li>
                        <h6 class="dropdown-header">Hello, {{ auth()->user()->username }}!</h6>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i> My
                            Profile</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                            Settings</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item"><i
                                    class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
