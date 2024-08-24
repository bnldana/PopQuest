<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $table = 'progress';

    protected $fillable = [
        'player_id', 
        'level_id', 
        'progress'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
