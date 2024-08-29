@include('cookie-consent::index')

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
    <!-- Desktop Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent d-none d-lg-flex">
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
                    <a class="nav-link" href="#leaderboard">{{ __('messages.Classement') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#faq">{{ __('messages.F.A.Q') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">{{ __('messages.Contact') }}</a>
                </li>
                <li class="nav-item playDiv">
                    <a class="nav-link play-button" style="color: var(--pop-white) !important;">
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

    <!-- Mobile Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent d-lg-none">
        <div>
            <a class="navbar-brand d-flex flex-row align-items-center" id="logoDiv" href="{{ app()->getLocale() == 'en' ? url('/en') : url('/') }}">
                <img src="{{ asset('/images/logo.svg') }}" alt="Logo">
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavMobile" aria-controls="navbarNavMobile" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavMobile">
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
                <li class="nav-item play-button playDiv">
                    <a class="nav-link play-button" href="#" style="color: var(--pop-white) !important;">
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

        <div class="modal fade" id="popModal" tabindex="-1" aria-labelledby="popModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popModalLabel">Merci !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <p>Ce projet est un projet open-source disponible sur <a href="https://github.com/bnldana/PopQuest">GitHub</a>.</p>
                    <p>Il n'aurait pas été possible sans le soutien de d'Emilie, Emma, Yolen, Morgane, et bien d'autres que j'oublie de citer car je suis ingrate.</p>
                    <p>Un grand merci également à M. Winstein qui m'a toujours poussée à me dépasser lors des séances de soutien</p>
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
        <p class="mb-1">&copy; 2024 Danowrld</p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
<script>
$(document).ready(function() {
    AOS.init();

    const leaderboardItems = document.querySelectorAll(".leaderboard-item");

    leaderboardItems.forEach((item, index) => {
    if (index < 3) {
        setTimeout(() => {
            item.classList.add("grow");
        }, index * 150);
    }
});

    $('.play-button').on('click', function(event) {
    event.preventDefault();
    const pseudo = getCookie('pseudo');
    const targetRoute = '{{ app()->getLocale() == "en" ? url("/en/levels") : url("/levels") }}';

    if (pseudo) {
        window.location.href = targetRoute;
    } else {
        $('#pseudoModal').modal('show');
    }
});

const progressBar = document.querySelector('.progressBar');

function fillprogressBar (){
  const windowHeight = window.innerHeight;
  const fullHeight = document.body.clientHeight;
  const scrolled = window.scrollY;
  const percentScrolled = (scrolled / (fullHeight - windowHeight)) * 100;

  progressBar.style.width = percentScrolled + '%';
};

window.addEventListener('scroll', fillprogressBar);

$('#pseudoForm').on('submit', function(event) {
    event.preventDefault();
    let pseudo = $('#pseudo').val();
    const targetRoute = '{{ app()->getLocale() == "en" ? url("/en/levels") : url("/levels") }}';

    if (pseudo) {
        document.cookie = `pseudo=${pseudo}; path=/; max-age=31536000; SameSite=Lax`;
        window.location.href = targetRoute;
    }
});

let typedSequence = '';
const targetSequence = 'pop';

document.addEventListener('keydown', function(event) {
    typedSequence += event.key.toLowerCase();

    if (typedSequence.includes(targetSequence)) {
        const popModal = new bootstrap.Modal(document.getElementById('popModal'));
        popModal.show();

        typedSequence = '';
    } else if (typedSequence.length > targetSequence.length) {
        typedSequence = typedSequence.slice(-targetSequence.length);
    }
});

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) {
        return parts.pop().split(';').shift();
    }
    return null;
}

const pseudo = getCookie('pseudo');
console.log('Vérification du cookie pseudo:', pseudo);

});
</script>
<script src="{{ asset('js/script.js') }}"></script>

</html>
