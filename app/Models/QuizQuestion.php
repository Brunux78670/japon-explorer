<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = ['prompt', 'choices', 'correct_answer', 'explanation', 'sort_order'];

    protected function casts(): array
    {
        return ['choices' => 'array', 'correct_answer' => 'integer', 'sort_order' => 'integer'];
    }
}
