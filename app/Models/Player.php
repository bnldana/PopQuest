<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pseudo',
        'level',
        'score',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * Define the relationship with the LevelScore model.
     */
    public function levelScores()
    {
        return $this->hasMany(LevelScore::class, 'pseudo', 'pseudo');
    }

    /**
     * Calculate the global score for the player.
     *
     * @return int
     */
    public function globalScore()
    {
        return $this->score;
    }

    /**
     * Get the current level of the player.
     *
     * @return int
     */
    public function currentLevel()
    {
        return $this->level;
    }

    /**
     * Record the completion of a level.
     *
     * @param int $level Level number that was completed
     * @param int $score Score for the completed level
     * @return void
     */
    public function completeLevel($level, $score)
    {
        if ($level > $this->level) {
            $this->level = $level;
        }

        $this->score += $score;
        $this->save();

        Score::create([
            'pseudo' => $this->pseudo,
            'level' => $level,
            'score' => $score,
        ]);
    }
}
