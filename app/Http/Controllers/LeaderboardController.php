<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function getTopFiveLeaderboardData()
    {
        return DB::table('global_scores')
            ->select('pseudo', 'total_score')
            ->orderBy('total_score', 'desc')
            ->take(5)
            ->get();
    }
    
    public function getAllLeaderboardData()
    {
        return DB::table('global_scores')
            ->select('pseudo', 'total_score')
            ->orderBy('total_score', 'desc')
            ->get();
    }

    public function getLevelLeaderboardData($levelId)
    {
        return DB::table('level_scores')
            ->select('pseudo', DB::raw('SUM(score) as total_score'))
            ->where('level', $levelId)
            ->groupBy('pseudo')
            ->orderByDesc('total_score')
            ->get();
    }

    public function showHomePage()
    {
        $results = $this->getTopFiveLeaderboardData();
        return view('welcome', ['results' => $results]);
    }
    
    public function showLeaderboardPage()
    {
        $results = $this->getAllLeaderboardData();
        $levels = DB::table('level_scores')
                    ->select('level')
                    ->distinct()
                    ->get(); // Fetching all distinct levels to display in the navbar
        return view('static.leaderboard', ['results' => $results, 'levels' => $levels]);
    }

    public function getLeaderboard($levelId = null)
    {
        if ($levelId && $levelId !== 'global') {
            $results = $this->getLevelLeaderboardData($levelId);
        } else {
            $results = $this->getAllLeaderboardData();
        }

        return response()->json([
            'html' => view('partials.leaderboard_list', ['results' => $results])->render(),
        ]);
    }
}
