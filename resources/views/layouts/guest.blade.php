<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    {{-- Icon Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        .input-password {
            position: relative;
        }

        .icon-eye,
        .icon-eye-confirm {
            position: absolute;
            font-size: 25px;
            top: 7px;
            right: 35px;
            cursor: pointer;
        }
    </style>

    <title>{{ $title }}</title>
</head>

<body>
    <section class="login-user">
        <div class="left">
            <img src="{{ asset('assets/images/ill_login_new.png') }}" alt="">
        </div>
        <div class="right">
            <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="">
            <h1 class="header-third">
                Start Today
            </h1>
            <p class="subheader">
                Because tomorrow become never
            </p>
            @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif
            <div class=" row">
                {{-- Form --}}
                {{ $slot }}
            </div>
            <p>
                @if (!request()->routeIs('verification.notice'))
                <a class="btn btn-border btn-google-login" href="{{ route('socialite.redirect') }}">
                    <img src="{{ asset('assets/images/ic_google.svg') }}" class="icon" alt=""> {{ $google }}
                </a>
                @endif
            </p>
            <img src="{{ asset('assets/images/people.png') }}" class="people" alt="">
        </div>
    </section>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous">
    </script>

    @stack('costum-js')

</body>

</html>
