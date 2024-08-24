<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function store(Request $request, $levelId)
    {
        $pseudo = isset($_COOKIE['pseudo']) ? $_COOKIE['pseudo'] : null;

        if (!$pseudo) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non identifié.'], 401);
        }

        $newScore = $request->input('score');

        try {
            $globalScore = DB::table('global_scores')->where('pseudo', $pseudo)->first();

            if (!$globalScore) {
                DB::table('global_scores')->insert([
                    'pseudo' => $pseudo,
                    'total_score' => $newScore,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // Le joueur existe déjà, on mettra à jour son score total plus tard si nécessaire
            }

            $existingScore = DB::table('level_scores')
                                ->where('pseudo', $pseudo)
                                ->where('level', $levelId)
                                ->first();

            if ($existingScore) {
                if ($newScore > $existingScore->score) {
                    $scoreDifference = $newScore - $existingScore->score;

                    DB::table('level_scores')
                        ->where('pseudo', $pseudo)
                        ->where('level', $levelId)
                        ->update([
                            'score' => $newScore,
                            'updated_at' => now(),
                        ]);

                    DB::table('global_scores')
                        ->where('pseudo', $pseudo)
                        ->increment('total_score', $scoreDifference);

                    return response()->json(['success' => true, 'message' => 'Score amélioré et mis à jour avec succès']);
                } else {
                    return response()->json(['success' => true, 'message' => 'Ancien score conservé, score actuel inférieur']);
                }
            } else {
                DB::table('level_scores')->insert([
                    'pseudo' => $pseudo,
                    'level' => $levelId,
                    'score' => $newScore,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('global_scores')
                    ->where('pseudo', $pseudo)
                    ->increment('total_score', $newScore);

                return response()->json(['success' => true, 'message' => 'Nouveau score enregistré avec succès']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'enregistrement du score: ' . $e->getMessage()], 500);
        }
    }
}
