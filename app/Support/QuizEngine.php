<?php

namespace App\Support;

final class QuizEngine
{
    /**
     * @param array{correct_answer:int, explanation?:string|null} $question
     * @return array{correct:bool, explanation:string}
     */
    public static function evaluate(array $question, int $choice): array
    {
        return [
            'correct' => $choice === (int) $question['correct_answer'],
            'explanation' => (string) ($question['explanation'] ?? ''),
        ];
    }
}
