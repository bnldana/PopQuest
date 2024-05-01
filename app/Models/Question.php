<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Question extends Model
{
    protected $fillable = ['level_id', 'question', 'option_a', 'option_b', 'option_c', 'option_d'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    protected $appends = ['choices'];

    public function getChoicesAttribute()
    {
        $options = collect([
            $this->option_a,
            $this->option_b,
            $this->option_c,
            $this->option_d,
        ])->toArray();
    
        $shuffledOptions = Arr::shuffle($options);
    
        return collect($shuffledOptions)->map(function ($option, $index) {
            return ['choice_text' => $option];
        });
    }    
}