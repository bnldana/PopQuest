<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{-- config('app.name', 'Popcorn Quest') --}}Popcorn Quest</title>

    <link href="{{ asset('style.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @if (Auth::check())
        @include('layouts.navigation')
        @endif

        <header>
            <div id="logoDiv">
                <a href="../index"><img src="{{ asset{images/logo.svg}"></a>
            </div>
            <div id="loginButton" class="userDiv" onclick="toggleBurgerMenu()">
                <p><?php
                    if (isset($user['username']) && !empty($user['username'])) {
                        echo htmlspecialchars($user['username']) . '<span id="burgerSymbol" class="burger-menu"><span class="burger-line"></span><span class="burger-line"></span><span class="burger-line"></span></span>';
                    } else {
                        echo "Connexion";
                    }
                    ?>
                </p>
                <div id="burgerMenu">
                    <ul>
                        <li><a href="../dashboard">Mon profil</a></li>
                        <li><a href="../map">Niveaux</a></li>
                        <li><a href="../leaderboard">Classement</a></li>
                        <li><a href="../faq">F.A.Q</a></li>
                        <li><a href="../contact">Contact</a></li>
                        <li><a href="../php/logout.php">Déconnexion</a></li>
                        <li>
                            <p>FR • EN</p>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main>
            @yield('content')
        </main>
    </div>
</body>

<footer>
    <p>© 2024 Danowrld</p>
    <p><a href="/legal">Mentions légales</a> | <a href="/privacy">Confidentialité</a> | <a href="/cookies">Cookies</a></p>
</footer>

</html>