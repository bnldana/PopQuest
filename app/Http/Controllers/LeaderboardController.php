<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function getTopFiveLeaderboardData()
    {
        return DB::table('global_scores')
            ->select('global_scores.pseudo', 'global_scores.total_score')
            ->orderBy('global_scores.total_score', 'desc')
            ->take(5)
            ->get();
    }
    
    public function getAllLeaderboardData()
    {
        return DB::table('global_scores')
            ->select('global_scores.pseudo', 'global_scores.total_score')
            ->orderBy('global_scores.total_score', 'desc')
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
        return view('static.leaderboard', ['results' => $results]);
    }
}
