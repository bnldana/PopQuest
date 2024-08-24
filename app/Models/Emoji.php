<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emoji extends Model
{
    use HasFactory;

    protected $table = 'emojis';

    protected $fillable = ['level', 'id', 'question', 'answer', 'answer_id'];
}