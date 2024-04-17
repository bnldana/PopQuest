<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        $results = DB::table('global_scores')
            ->join('users', 'global_scores.user_id', '=', 'users.id')
            ->select('users.username', 'global_scores.global_score')
            ->orderByDesc('global_scores.global_score')
            ->limit(5)
            ->get();

        return view('static.leaderboard', ['results' => $results]);
    }
}
