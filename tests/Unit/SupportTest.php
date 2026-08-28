<?php

use App\Support\QuizEngine;
use App\Support\TextNormalizer;

it('normalizes accented Japanese place names for search', function () {
    expect(TextNormalizer::normalize('Époque Jōmon — Tōkyō'))->toBe('epoque jomon tokyo');
});

it('evaluates quiz answers', function () {
    $question = ['correct_answer' => 2, 'explanation' => 'Explication'];

    expect(QuizEngine::evaluate($question, 2)['correct'])->toBeTrue()
        ->and(QuizEngine::evaluate($question, 1)['correct'])->toBeFalse();
});
