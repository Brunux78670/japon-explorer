<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizQuestionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (require database_path('data/quiz.php') as $index => $question) {
            QuizQuestion::query()->updateOrCreate(
                ['prompt' => $question['prompt']],
                $question + ['sort_order' => ($index + 1) * 10],
            );
        }
    }
}
