<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white mb-5">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/images/logo.png') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('main.dashboard') ? 'active': '' }}" aria-current="page"
                        href="#">Program</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Mentor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Business</a>
                </li>
            </ul>
            @guest
            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn btn-master btn-secondary me-3">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="btn btn-master btn-primary">
                    Sign Up
                </a>
            </div>
            @else
            <div class="dropdown">
                <a class="text-decoration-none text-black" style="cursor: pointer" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ auth()->user()->name }}
                    <img src="{{ auth()->user()->avatar ?? asset('assets/images/ic_globe-2.png') }}" height="40"
                        class="ms-2 user-photo rounded-circle">
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">My Dashboard</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </div>
            @endguest

        </div>
    </div>
</nav>
