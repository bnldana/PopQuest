@extends("layouts.app")

@section("body-id", "home")

@section("content")
<!--
<div id="randomizer">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path d="M403.8 34.4c12-5 25.7-2.2 34.9 6.9l64 64c6 6 9.4 14.1 9.4 22.6s-3.4 16.6-9.4 22.6l-64 64c-9.2 9.2-22.9 11.9-34.9 6.9s-19.8-16.6-19.8-29.6V160H352c-10.1 0-19.6 4.7-25.6 12.8L284 229.3 244 176l31.2-41.6C293.3 110.2 321.8 96 352 96h32V64c0-12.9 7.8-24.6 19.8-29.6zM164 282.7L204 336l-31.2 41.6C154.7 401.8 126.2 416 96 416H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H96c10.1 0 19.6-4.7 25.6-12.8L164 282.7zm274.6 188c-9.2 9.2-22.9 11.9-34.9 6.9s-19.8-16.6-19.8-29.6V416H352c-30.2 0-58.7-14.2-76.8-38.4L121.6 172.8c-6-8.1-15.5-12.8-25.6-12.8H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H96c30.2 0 58.7 14.2 76.8 38.4L326.4 339.2c6 8.1 15.5 12.8 25.6 12.8h32V320c0-12.9 7.8-24.6 19.8-29.6s25.7-2.2 34.9 6.9l64 64c6 6 9.4 14.1 9.4 22.6s-3.4 16.6-9.4 22.6l-64 64z" />
    </svg>
</div>
-->
<div class="progressBar" style="width: 0%;"></div>
<div class="my-5" style="gap: 200px; display: flex; flex-direction: column;">
    <div class="row align-items-center mb-5">
        <div class="col-md-5" style="display: flex;gap: 20px;flex-direction: column;">
            <h1>La quête du popcorn</h1>
            <p>Bienvenue dans Popcorn Quest, un super jeu en ligne pour tous les fans de cinéma !</p>
            <p>Teste tes connaissances avec huit quiz sur différents thèmes du cinéma. Essaie de faire le meilleur score pour devenir le roi du grand écran.</p>
            <p>Alors, prêt à relever le défi ?</p>
            <div class="button-container mt-3">
                <button id="playButton" class="default">C'est parti !</button>
            </div>
        </div>
        <div class="col-md-7" style="height: 550px;">
            <div class="bg-image">
                <div class="gradient-overlay">
                </div>
            </div>
        </div>
    </div>

    <div id="leaderboard" class="mb-5">
        <h1 class="mb-4">Le top 5</h1>
        <ul class="leaderboard-list mb-4">
            <!-- Leaderboard items -->
        </ul>
        <div class="button-container">
            <button id="playButton" class="default">Faites mieux !</button>
        </div>
    </div>

    <div id="faq" class="mb-5">
        <h1 class="mb-4">F.A.Q</h1>
        <div class="row g-4 mb-3">
            <div class="col-md-4">
                <h3>Dois-je créer un compte pour jouer ?</h3>
                <p>Oui, la création d'un compte permet de sauvegarder votre progression, personnaliser votre avatar et voir votre position dans le classement.</p>
            </div>
            <div class="col-md-4">
                <h3>Puis-je jouer sur mobile ?</h3>
                <p>Oui, le jeu est conçu pour être responsive et accessible sur tous les appareils, y compris les smartphones et les tablettes.</p>
            </div>
            <div class="col-md-4">
                <h3>Que faire si je trouve une question incorrecte ou une autre erreur ?</h3>
                <p>Nous vous encourageons à utiliser <a href="{{ route('contact') }}">le formulaire de contact</a> pour nous en informer. Nous examinerons la question et apporterons les corrections nécessaires !</p>
            </div>
        </div>
    </div>

    <div id="contact" class="mb-5">
        <h1 class="mb-4">Contacte-nous</h1>
        <p class="mb-4">Tu as des questions ou des commentaires? On t'écoute !</p>
        <form action="" method="post">
            @csrf <!-- CSRF token for security -->
            <div class="mb-3">
                <label for="name" class="form-label">Ton nom</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Ton email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Ton message</label>
                <textarea id="message" name="message" rows="4" class="form-control" required></textarea>
            </div>

            <button type="submit" name="submit" class="default">Envoyer</button>
        </form>
    </div>
</div>

<script>
    const progressBar = document.querySelector('.progressBar');

    function fillprogressBar (){
    const windowHeight = window.innerHeight;
    const fullHeight = document.body.clientHeight;
    const scrolled = window.scrollY;
    const percentScrolled = (scrolled / (fullHeight - windowHeight)) * 100;

    progressBar.style.width = percentScrolled + '%';
    };

    window.addEventListener('scroll', fillprogressBar);

    document.addEventListener("DOMContentLoaded", function() {
        const isAuthenticated = @json(auth()->check());

        const playButton = document.getElementById("playButton");
        playButton.addEventListener("click", function() {
            if (isAuthenticated) {
                window.location.href = "{{ route("levels.index")}}";
            } else {
                $("#registerModal").modal("show");
            }
        });
    });
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = elementPosition - (window.innerHeight / 2) + (targetElement.offsetHeight / 2);

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            });
        });
</script>
@endsection