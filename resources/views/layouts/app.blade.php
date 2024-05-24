<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Popcorn Quest</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="icon" href="{{ asset('images/kernel.svg') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body id="@yield('body-id', 'default-id')" class="@yield('body-class', 'default-class')">
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
            <div>
                <a class="navbar-brand d-flex flex-row align-items-center" id="logoDiv" href="{{ url('/') }}">
                    <img src="{{ asset('/images/logo.svg') }}">
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav text-uppercase" style="gap: 20px">
                    <li class="nav-item">
                        <a class="nav-link" href="#leaderboard">Classement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq">F.A.Q</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item playDiv">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal" style="color: var(--pop-white) !important;"><i class="fa-solid fa-gamepad"></i> JOUER !</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Connexion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('auth.login')
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Inscription</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('auth.register')
                </div>
            </div>
        </div>
    </div>

    <script>
        const loginButton = document.getElementById('loginButton');
        loginButton.addEventListener('click', function() {
            @if(auth()->check())
            burgerMenu.classList.toggle("burgerMenuDisplay");
            burgerSymbol.classList.toggle('open');
            @else
            $('#loginModal').modal('show');
            @endif
        });
    </script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

<footer>
    <p>© 2024 Danowrld</p>
    <p><a href="{{ url('/legal') }}">Mentions légales</a> | <a href="{{ url('/privacy') }}">Confidentialité</a> | <a href="{{ url('/cookies') }}">Cookies</a></p>
</footer>

</html>
