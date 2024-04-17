@extends('layouts.static')

@section('title', 'Leaderboard')

@section('pageContent')
<h1>LE TOP 5</h1>
<ul class='leaderboard-list'>
    @foreach ($results as $index => $row)
    <li class='leaderboard-item'>
        @if ($index == 0)
        <span class='crown-icon'>👑</span>
        @endif
        <span class='score'>{{ $row->global_score }}</span>
        <div class='user-ldb'>
            <span class='rank'>{{ $index + 1 }}</span>
            <span class='username'>{{ $row->username }}</span>
        </div>
    </li>
    @endforeach
</ul>
<div class='button-container'>
    <button id='playButton' class='default'>Faites mieux !</button>
</div>
@endsection