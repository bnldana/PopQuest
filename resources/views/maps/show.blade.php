@extends('layouts.app')

@section('content')
<div id="map-container">
    @forelse ($levels as $level)
    @php
    $levelUnlocked = $level->level <= $currentLevel; $levelClass=$levelUnlocked ? 'unlocked' : 'locked' ; $score=$levelScores[$level->level]->level_score ?? null;
        @endphp

        @if ($levelUnlocked)
        <a href="{{ route('quiz.start', ['level' => $level->level]) }}" class="level-link">
            @endif

            <div class="level-container {{ $levelClass }}">
                <div class="level-card">
                    <h3>{{ $level->level }}</h3>
                    @if ($score !== null)
                    <p>{{ $score }} pts</p>
                    @endif
                </div>
                <div class="level-shadow"></div>
            </div>

            @if ($levelUnlocked)
        </a>
        @endif
        @empty
        <p>Aucun niveau trouvé.</p>
        @endforelse
</div>
@endsection