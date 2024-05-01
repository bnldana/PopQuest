
<?php

namespace App\Http\Controllers;

use App\Models\Question;

class GameController extends Controller
{
    public function fetchQuestion(Level $level, Question $question)
    {
        $nextQuestion = Question::where('level_id', $level->id)->where('id', '>', $question->id)->first();
        return response()->json([
            'status' => 'success',
            'question' => $question->load('choices'),
            'next_question_id' => optional($nextQuestion)->id,
            'is_last_question' => is_null($nextQuestion)
        ]);
    }
}
