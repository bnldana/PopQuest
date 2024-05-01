<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'last_completed_level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userScores()
    {
        return $this->hasMany(UserScore::class);
    }

    
    /**
     * Calculate the global score for the user.
     */
    public function globalScore()
    {
        return $this->userScores()->sum('score');
    }

        /**
     * Get the current level of the user.
     *
     * @return int
     */
    public function currentLevel()
    {
        // Returns the next level they need to start
        return $this->last_completed_level + 1;
    }

    /**
     * Record the completion of a level.
     *
     * @param int $level Level number that was completed
     * @return void
     */
    public function completeLevel($level)
    {
        if ($level > $this->last_completed_level) {
            $this->last_completed_level = $level;
            $this->save();
        }
    }
}
