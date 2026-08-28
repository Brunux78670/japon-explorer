<?php

use App\Livewire\Search\GlobalSearch;
use App\Services\SearchService;
use Livewire\Livewire;

it('finds an article by title', function () {
    $this->seed();

    Livewire::test(GlobalSearch::class)
        ->set('query', 'ramen')
        ->assertSee('Ramen');
});

it('finds accented content from an unaccented query', function () {
    $this->seed();

    $slugs = app(SearchService::class)->search('jomon')->pluck('slug')->all();
    expect($slugs)->toContain('jomon');
});
