<?php

namespace App\Livewire\Japanese;

use App\Models\QuizQuestion;
use App\Support\QuizEngine;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Quiz extends Component
{
    public int $currentIndex = 0;
    public int $score = 0;
    public ?int $selected = null;
    public bool $answered = false;
    public bool $correct = false;
    public bool $finished = false;
    public string $explanation = '';

    public function answer(int $choice): void
    {
        if ($this->answered || $this->finished) {
            return;
        }

        $question = $this->currentQuestion();
        if (! $question || ! array_key_exists($choice, $question->choices)) {
            return;
        }

        $result = QuizEngine::evaluate([
            'correct_answer' => $question->correct_answer,
            'explanation' => $question->explanation,
        ], $choice);

        $this->selected = $choice;
        $this->answered = true;
        $this->correct = $result['correct'];
        $this->explanation = $result['explanation'];

        if ($this->correct) {
            $this->score++;
        }
    }

    public function next(): void
    {
        if (! $this->answered || $this->finished) {
            return;
        }

        $total = QuizQuestion::query()->count();
        if ($this->currentIndex + 1 >= $total) {
            $this->finished = true;
            return;
        }

        $this->currentIndex++;
        $this->resetQuestionState();
    }

    public function restart(): void
    {
        $this->currentIndex = 0;
        $this->score = 0;
        $this->finished = false;
        $this->resetQuestionState();
    }

    public function render(): View
    {
        return view('livewire.japanese.quiz', [
            'question' => $this->finished ? null : $this->currentQuestion(),
            'total' => QuizQuestion::query()->count(),
        ]);
    }

    private function currentQuestion(): ?QuizQuestion
    {
        return QuizQuestion::query()->orderBy('sort_order')->orderBy('id')->skip($this->currentIndex)->first();
    }

    private function resetQuestionState(): void
    {
        $this->selected = null;
        $this->answered = false;
        $this->correct = false;
        $this->explanation = '';
    }
}
