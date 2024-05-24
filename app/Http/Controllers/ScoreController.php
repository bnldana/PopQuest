<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function store(Request $request, $level_id)
    {
        DB::beginTransaction();
        try {
            $score = Score::create([
                'user_id' => auth()->id(),
                'level_id' => $level_id,
                'score' => $request->score
            ]);

            $user = auth()->user();
            $user->last_completed_level = $level_id;
            $user->save();

            DB::commit();

            return response()->json([
                'message' => 'Score saved and user updated successfully!',
                'score' => $score,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to update score and user level'], 500);
        }
    }
}
