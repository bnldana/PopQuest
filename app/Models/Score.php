<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'level_scores';

    protected $fillable = ['user_id', 'level_id', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Get the total score for a specific user.
     */
    public static function getGlobalScore($userId)
    {
        return self::where('user_id', $userId)->sum('score');
    }
}
