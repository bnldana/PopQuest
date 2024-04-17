@extends('layouts.static')

@section('title', 'FAQ')

@section('pageContent')
<h1>F.A.Q</h1>
<div class="question">
    <h3>Dois-je créer un compte pour jouer ?</h3>
</div>
<p class="answer">Oui, la création d'un compte permet de sauvegarder votre progression, personnaliser votre avatar et voir votre position dans le classement.</p>

<div class="question">
    <h3>Puis-je jouer sur mobile ?</h3>
</div>
<p class="answer">Oui, le jeu est conçu pour être responsive et accessible sur tous les appareils, y compris les smartphones et les tablettes.</p>

<div class="question">
    <h3>Que faire si je trouve une question incorrecte ou une autre erreur ?</h3>
</div>
<p class="answer">Nous vous encourageons à utiliser <a href="{{ route('contact') }}">le formulaire de contact</a> pour nous en informer. Nous examinerons la question et apporterons les corrections nécessaires !</p>
@endsection