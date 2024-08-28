<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Popcorn Quest</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="icon" href="{{ asset('images/kernel.svg') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body id="@yield('body-id', 'default-id')" class="@yield('body-class', 'default-class')">
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
    <div>
    <a class="navbar-brand d-flex flex-row align-items-center" id="logoDiv" href="{{ app()->getLocale() == 'en' ? url('/en') : url('/') }}">
        <img src="{{ asset('/images/logo.svg') }}" alt="Logo">
    </a>
</div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav text-uppercase" style="gap: 20px">
        <li class="nav-item">
            <a class="nav-link" href="{{ app()->getLocale() == 'en' ? '/en/leaderboard' : '/leaderboard' }}">
                {{ __('messages.Classement') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ app()->getLocale() == 'en' ? '/en/levels' : '/levels' }}">
                {{ __('messages.Niveaux') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ app()->getLocale() == 'en' ? '/en/contact' : '/contact' }}">{{ __('messages.Contact') }}</a>
        </li>
        <li class="nav-item playDiv">
            <a class="nav-link" href="#" id="playButton" style="color: var(--pop-white) !important;">
                <i class="fa-solid fa-gamepad"></i> {{ __('messages.JOUER !') }}
            </a>
        </li>

        @if (app()->getLocale() === 'fr')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('set-locale', ['locale' => 'en']) }}">
                <img style="width: 35px !important;" src="{{ asset('/images/raten.png') }}" alt="Rat EN">
                </a>
            </li>
        @elseif (app()->getLocale() === 'en')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('set-locale', ['locale' => 'fr']) }}">
                <img style="width: 35px !important;" src="{{ asset('/images/ratfr.png') }}" alt="Rat FR">
                </a>
            </li>
        @endif
    </ul>
</div>
    </nav>
</header>

    <main>
        @yield('content')
    </main>

    <!-- User Modal -->
    <div class="modal fade" id="pseudoModal" tabindex="-1" role="dialog" aria-labelledby="pseudoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pseudoModalLabel">Entre ton pseudo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="pseudoForm" method="POST" action="{{ route('pseudo.store') }}">
                        @csrf 
                        <div class="form-group">
                            <label for="pseudo" class="sr-only">Pseudo</label>
                            <input type="text" class="form-control" id="pseudo" placeholder="Ton pseudo" required>
                        </div>
                        <button type="submit" class="default">Go !</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

<footer class="text-center py-3">
    <div class="container-div">
        <div class="row justify-content-center">
            <div class="col-auto">
                <a href="{{ app()->getLocale() == 'en' ? url('/en/legal') : url('/legal') }}">{{ __('messages.Mentions légales') }}</a>
            </div>
            <div class="col-auto">
                <a href="{{ app()->getLocale() == 'en' ? url('/en/privacy') : url('/privacy') }}">{{ __('messages.Confidentialité') }}</a>
            </div>
            <div class="col-auto">
                <a href="{{ app()->getLocale() == 'en' ? url('/en/cookies') : url('/cookies') }}">{{ __('messages.Cookies') }}</a>
            </div>
        </div>
    </div>
    <p class="mb-1">&copy; 2024 Danowrld</p>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
$(document).ready(function() {
    AOS.init();

    $('#playButton').on('click', function(event) {
    event.preventDefault();
    const pseudo = getCookie('pseudo');
    const targetRoute = '{{ app()->getLocale() == "en" ? url("/en/levels") : url("/levels") }}';

    if (pseudo) {
        window.location.href = targetRoute;
    } else {
        $('#pseudoModal').modal('show');
    }
});

$('#pseudoForm').on('submit', function(event) {
    event.preventDefault();
    let pseudo = $('#pseudo').val();
    const targetRoute = '{{ app()->getLocale() == "en" ? url("/en/levels") : url("/levels") }}';

    if (pseudo) {
        document.cookie = `pseudo=${pseudo}; path=/; max-age=31536000; SameSite=Lax`;
        window.location.href = targetRoute;
    }
});
});
    </script>
    <script src="{{ asset('js/script.js') }}"></script>

</html>
