{{-- resources/views/levels/index.blade.php --}}

@extends('layouts.app')

@section('content')

<div id="map-container">
    @if($levels->count() > 0)
        @foreach($levels as $level)
            @php
                $levelUnlocked = $level->id <= auth()->user()->currentLevel();
                $levelClass = $levelUnlocked ? 'unlocked' : 'locked';

                $score = $levelUnlocked ? \App\Models\Score::where('user_id', auth()->id())->where('level_id', $level->id)->first() : null;
                $scoreValue = $score ? $score->score : null;
            @endphp

            @if($levelUnlocked)
                <a href="{{ route('levels.show', $level) }}" class="level-link">
            @endif

            <div class="level-container {{ $levelClass }}">
                <div class="level-card">
                    <h3>{{ $level->id }}</h3>
                    @if($scoreValue !== null)
                        <p>Score: {{ $scoreValue }}</p>
                    @endif
                </div>
                <div class="level-shadow"></div>
            </div>

            @if($levelUnlocked)
                </a>
            @endif
        @endforeach
    @else
        <p>Aucun niveau trouvé.</p>
    @endif
</div>

@endsection
