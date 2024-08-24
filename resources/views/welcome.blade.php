@extends("layouts.home")

@section("body-id", "home")

@section("content")
<div class="progressBar" style="width: 0%;"></div>
<div class="my-5 flex-wrapper" style="gap: 200px; display: flex; flex-direction: column;">
    <div id="welcome" class="row align-items-center mb-5" data-aos="fade-up" data-aos-offset="200" data-aos-duration="1000">
        <div class="col-md-5 text-content">
            <h1>{{ __('messages.La quête du popcorn') }}</h1>
                <div class="wrapper">
                    <p>{{ __('messages.Bienvenue dans Popcorn Quest, le jeu pour tous les fans de cinéma !') }}</p>
                    <p>{{ __('messages.Teste tes connaissances avec huit mini-quiz sur différents thèmes du ciné. Fais le meilleur score et deviens le roi du grand écran.') }}</p>
                    <p>{{ __('messages.Alors, prêt à relever le défi ?') }}</p>
                    <p>Locale dans app()->getLocale(): {{ app()->getLocale() }}</p>
                    <p>Locale dans la session: {{ session('locale') }}</p>
                </div>
            <div class="button-container mt-3">
                <button id="playButton" class="default">{{ __("messages.C'est parti !") }}</button>
            </div>
        </div>
        <div class="col-md-7 image-container">
            <div class="bg-image">
                <div class="gradient-overlay"></div>
            </div>
        </div>
    </div>

    <div id="leaderboard" class="mb-5" data-aos="fade-up" data-aos-offset="200" data-aos-duration="1000">
        <h1 class="mb-4">{{ __('messages.Le classement') }}</h1>
        <div class="leaderboard-list mb-4">
        <ul>
            @foreach ($results->slice(0, 5) as $index => $row)
                <li class='leaderboard-item'>
                    @if ($index == 0)
                        <i class="fa-solid fa-crown"></i>
                    @endif
                    <div class='user-ldb'>
                        <span class='rank'>{{ $index + 1 }}</span>
                        <span class='username'>{{ $row->pseudo }}</span>
                    </div>
                    <span class='score'>{{ $row->total_score }}</span>
                </li>
            @endforeach
        </ul>
        <a href="/leaderboard" style="text-align: center; color: white;">Voir le classement entier</a>
        <div class="buttons-container">
                <div class="button-container">
                    <button id="playButton" class="default">{{ __('messages.Fais mieux !') }}</button>
                </div>
            </div>
    </div>
</div>

    <div id="faq" class="mb-5">
        <h1 class="mb-4" data-aos="fade-up" data-aos-offset="200" data-aos-duration="1000">{{ __('F.A.Q') }}</h1>
        <div class="row g-4 mb-3">
            <div class="col-md-4 faq-item" data-aos="fade-up" data-aos-offset="200" data-aos-duration="1000" data-aos-delay="100">
                <h3>{{ __('messages.Dois-je créer un compte pour jouer ?') }}</h3>
                <p>{{ __("messages.Non, pas besoin. Clique sur Jouer, entre ton pseudo et c'est parti !") }}</p>
            </div>
            <div class="col-md-4 faq-item" data-aos="fade-up" data-aos-offset="200" data-aos-duration="1000" data-aos-delay="200">
                <h3>{{ __('messages.Puis-je jouer sur mobile ?') }}</h3>
                <p>{{ __('messages.Oui, le jeu est conçu pour être responsive et accessible sur tous les appareils, y compris les smartphones et les tablettes.') }}</p>
            </div>
            <div class="col-md-4 faq-item" data-aos="fade-up" data-aos-offset="200" data-aos-duration="1000" data-aos-delay="300">
                <h3>{{ __('messages.Que faire si je trouve une question incorrecte ou une autre erreur ?') }}</h3>
                <p>{!! __('messages.Nous t\'encourageons à utiliser <a href="#contact">le formulaire de contact</a> pour nous en informer. Nous examinerons la question et apporterons les corrections nécessaires !') !!}</p>
            </div>
        </div>
    </div>

    <div id="contact" class="mb-5" data-aos="fade-up" data-aos-offset="200" data-aos-duration="1000">
        <h1 class="mb-4">{{ __('messages.Contacte-nous') }}</h1>
        <p class="mb-4">{{ __('messages.Tu as des questions ou des commentaires? On t\'écoute !') }}</p>
        <form action="" method="post">
            @csrf <!-- CSRF token for security -->
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('messages.Ton nom') }}</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('messages.Ton email') }}</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">{{ __('messages.Ton message') }}</label>
                <textarea id="message" name="message" rows="4" class="form-control" required></textarea>
            </div>

            <button type="submit" name="submit" class="default">{{ __('messages.Envoyer') }}</button>
        </form>
    </div>
</div>

<button id="back-to-top" class="default">
    <i class="fas fa-arrow-up"></i>
</button>
@endsection