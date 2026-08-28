<?php

use App\Livewire\Japanese\Quiz as JapaneseQuiz;
use Livewire\Livewire;

it('increments score for the first correct answer', function () {
    $this->seed();

    Livewire::test(JapaneseQuiz::class)
        ->call('answer', 0)
        ->assertSet('answered', true)
        ->assertSet('correct', true)
        ->assertSet('score', 1);
});

it('can restart the quiz', function () {
    $this->seed();

    Livewire::test(JapaneseQuiz::class)
        ->call('answer', 0)
        ->call('restart')
        ->assertSet('currentIndex', 0)
        ->assertSet('score', 0)
        ->assertSet('answered', false);
});
