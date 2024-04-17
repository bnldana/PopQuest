<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
    public function showMap()
    {
        $userId = Auth::id();
        $currentLevel = 1;

        if ($userId) {
            $currentLevel = DB::table('progression')
                ->where('user_id', $userId)
                ->value('current_level') ?? 1;
        }

        $levels = DB::table('levels')->get();
        $levelScores = DB::table('level_scores')
            ->where('user_id', $userId)
            ->get()
            ->keyBy('level')
            ->all();

        return view('maps.show', [
            'levels' => $levels,
            'currentLevel' => $currentLevel,
            'levelScores' => $levelScores
        ]);
    }
}
