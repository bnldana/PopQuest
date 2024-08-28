<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use App\Models\Level;
use App\Models\Question;
use App\Models\Emoji;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $levels = Level::all();

        $pseudo = isset($_COOKIE['pseudo']) ? $_COOKIE['pseudo'] : null;

        $userScores = [];
        if (!empty($pseudo)) {
            $userScores = DB::table('level_scores')
                            ->where('pseudo', $pseudo)
                            ->pluck('score', 'level')
                            ->toArray();
        }

        return view('levels.index', compact('levels', 'userScores'));
    }

    public function showLevel(Request $request, $id)
    {
        $level = Level::with('questions')->findOrFail($id);
    
        foreach ($level->questions as $question) {
            $question->text = Lang::get('questions.' . $question->id);
            
            $question->option_a = Lang::get('questions.' . $question->id . '_option_a');
            $question->option_b = Lang::get('questions.' . $question->id . '_option_b');
            $question->option_c = Lang::get('questions.' . $question->id . '_option_c');
            $question->option_d = Lang::get('questions.' . $question->id . '_option_d');
        }
    
        return view('levels.show', [
            'level' => $level,
            'isLevel2' => $id == 2
        ]);
    }    

    public function fetchQuestion(Level $level, Question $question)
    {
        $nextQuestion = Question::where('level_id', $level->id)
            ->where('id', '>', $question->id)
            ->first();

        $question->text = Lang::get('questions.' . $question->id);

        return response()->json([
            'status' => 'success',
            'question' => $question->load('choices'),
            'next_question_id' => optional($nextQuestion)->id,
            'is_last_question' => is_null($nextQuestion)
        ]);
    }

    public function verifyAnswer(Request $request, $levelId, $questionId)
    {
        Log::info('verifyAnswer called', [
            'levelId' => $levelId,
            'questionId' => $questionId,
            'request_data' => $request->all()
        ]);
    
        $request->validate([
            'selectedOption' => 'required|string',
        ]);
    
        $selectedText = $request->input('selectedOption');
    
        Log::info('Selected option', ['selectedText' => $selectedText]);
    
        $questionFr = DB::table('questions')->where('id', $questionId)->value('option_d');
        $questionEn = DB::table('questions_en')->where('id', $questionId)->value('option_d');
    
        Log::info('Correct answer from questions table (FR)', ['correct_answer_fr' => $questionFr]);
        Log::info('Correct answer from questions_en table (EN)', ['correct_answer_en' => $questionEn]);
    
        $isCorrect = ($selectedText === $questionFr || $selectedText === $questionEn);
    
        Log::info('Answer comparison result', [
            'isCorrect' => $isCorrect
        ]);
    
        return response()->json(['correct' => $isCorrect]);
    }
    

    public function getEmojiData()
    {
        $questions = Emoji::where('level', 2)
            ->orderBy('id', 'asc')
            ->get(['id', 'question', 'answer_id']);

        return response()->json($questions);
    }

    public function checkLevel2Answer(Request $request)
    {
        $input = $request->json()->all();

        if (isset($input['movieId'])) {
            $movieId = $input['movieId'];

            $correct = Emoji::where('answer_id', $movieId)->exists();

            return response()->json([
                'correct' => $correct,
            ]);
        } else {
            return response()->json([
                'error' => 'Movie ID not provided',
            ], 400);
        }
    }
}
