@extends('layouts.static')

@section('title', 'leaderboard')

@section("body-id", "leaderboard")

@section('pageContent')
<h1 class="mb-4">{{ __('messages.Le classement') }}</h1>

<nav class="leaderboard-navbar">
    <ul>
        <li><a href="#" data-level="global" class="active">{{ __('messages.Global') }}</a></li>
        @foreach ($levels as $level)
        <li>
            <a href="#" data-level="{{ $level->level }}">
                <span class="full-label">{{ __('messages.Niveau') }} {{ $level->level }}</span>
                <span class="short-label">{{ __('messages.Nv') }} {{ $level->level }}</span>
            </a>
        </li>
        @endforeach
    </ul>
</nav>

<div id="leaderboard-content" class="leaderboard-list mb-4">
<div id="loading-spinner" style="display: none;">
    <div class="spinner"></div>
</div>
    @include('partials.leaderboard_list', ['results' => $results])
</div>

<div class="button-container">
    <button id="playButton" class="play-button default">{{ __('messages.Fais mieux !') }}</button>
</div>

@endsection
