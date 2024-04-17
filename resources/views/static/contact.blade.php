@extends('layouts.static')

@section('title', 'Contact')

@section('pageContent')
<h1>CONTACTE-NOUS</h1>
<p>Tu as des questions ou des commentaires? On t'écoute !</p>
<form action="{{ route('contact.submit') }}" method="post">
    @csrf <!-- CSRF token for security -->
    <label for="name">Ton nom</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Ton email</label>
    <input type="email" id="email" name="email" required>

    <label for="message">Ton message</label>
    <textarea id="message" name="message" rows="4" required></textarea>

    <button type="submit" name="submit" class="default">Envoyer</button>
</form>
@endsection