@extends('layouts.app')

@section('body-class', 'map')

@section('content')

@if(isset($error))
    <p>{{ $error }}</p>
@else
    <div id="map-container">
        @if($levels->count() > 0)
            @foreach($levels as $index => $level)
                @php
                    $scoreValue = $userScores[$level->id] ?? null;
                    $delay = $index * 100; 
                    $animationDirection = ($index % 2 === 0) ? 'flip-up' : 'flip-down';
                @endphp

                <a href="{{ route('levels.show', $level->id) }}" class="level-link">
                    <div class="level-container" data-aos="{{ $animationDirection }}" data-aos-delay="{{ $delay }}">
                        <div class="level-card">
                            <h3>{{ $level->id }}</h3>
                            @if($scoreValue !== null)
                                <p>{{ $scoreValue }} pts</p>
                            @endif
                        </div>
                        <div class="level-shadow"></div>
                    </div>
                </a>
            @endforeach
        @else
            <p>Aucun niveau trouvé.</p>
        @endif
    </div>
@endif

@endsection
