<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class QuestionEn extends Model
{
    protected $table = 'questions_en';

    public function level()
    {
        return $this->belongsTo(LevelEn::class, 'level_id', 'id');
    }

    public $timestamps = false;

    protected $appends = ['choices'];

    public function getChoicesAttribute()
    {
        $options = collect([
            'a' => $this->option_a,
            'b' => $this->option_b,
            'c' => $this->option_c,
            'd' => $this->option_d,
        ]);

        $shuffledOptions = $options->shuffle();

        return $shuffledOptions->map(function ($option, $key) {
            return ['choice_text' => $option, 'key' => $key];
        })->values();
    }

    public function getCorrectOptionAttribute()
    {
        return $this->option_d;
    }

    public function isCorrect($selectedText)
    {
        return trim(strtolower($selectedText)) === trim(strtolower($this->getCorrectOptionAttribute()));
    }
}
