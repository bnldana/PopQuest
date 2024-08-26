@extends('layouts.static')

@section('title', 'leaderboard')

@section('pageContent')
<h1 class="mb-4">{{ __('messages.Le classement') }}</h1>
<div class="leaderboard-list mb-4">
        <ul>
            @foreach ($results as $index => $row)
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
        <div class="button-container">
                    <button id="playButton" class="default">{{ __('messages.Fais mieux !') }}</button>
                </div>
</div>
@endsection