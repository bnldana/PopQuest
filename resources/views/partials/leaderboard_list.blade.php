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
