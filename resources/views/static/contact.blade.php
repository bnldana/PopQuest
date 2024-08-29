@extends('layouts.static')

@section("body-id", "contact")

@section('title', 'contact')

@section('pageContent')
        <h1 class="mb-4">{{ __('messages.Contacte-nous') }}</h1>
        <p class="mb-4">{{ __('messages.Tu as des questions ou des commentaires? On t\'écoute !') }}</p>
        <form action="{{ route('contact') }}" method="post">
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
@endsection