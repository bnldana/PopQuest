<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelEn extends Model
{
    protected $table = 'levels_en';

    public function questions()
    {
        return $this->hasMany(QuestionEn::class, 'level_id', 'id');
    }

    public function userScores()
    {
        return $this->hasMany(Score::class);
    }
}
