<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Level;
use App\Models\Question;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::all();
        $currentLevel = 1;

        if (Auth::check()) {
            $user = Auth::user();
            $currentLevel = $user->currentLevel();  // Ensure this method is defined in User model
        }

        return view('levels.index', compact('levels', 'currentLevel'));
    }

    public function show($id)
    {
        $level = Level::with('questions')->findOrFail($id);
        return view('levels.show', ['level' => $level]);
    }

    public function fetchQuestion(Level $level, Question $question)
    {
        $nextQuestion = Question::where('level_id', $level->id)->where('id', '>', $question->id)->first();
        return response()->json([
            'status' => 'success',
            'question' => $question->load('choices'),  // Ensure this method returns 
            'next_question_id' => optional($nextQuestion)->id,
            'is_last_question' => is_null($nextQuestion)
        ]);
    }

    public function verifyAnswer(Request $request, $levelId, $questionId)
    {
        $selectedText = $request->input('selectedOption');
        $question = Question::findOrFail($questionId);
    
        $isCorrect = ($selectedText === $question->option_d);
    
        return response()->json(['correct' => $isCorrect]);
    }
    
}
