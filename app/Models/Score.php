<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'level_scores';

    protected $fillable = ['pseudo', 'level', 'score'];

    /**
     * Define the relationship with the User model.
     */
    public function player()
    {
        return $this->belongsTo(Player::class, 'pseudo', 'pseudo');
    }

    /**
     * Define the relationship with the Level model.
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'level', 'id');
    }

    /**
     * Get the total score for a specific user.
     */
    public static function getGlobalScore($pseudo)
    {
        return self::where('pseudo', $pseudo)->sum('score');
    }
}