<?php

use App\Models\Article;

it('seeds exactly forty migrated articles', function () {
    $this->seed();

    expect(Article::query()->count())->toBe(40);
});

it('serves every principal public page', function () {
    $this->seed();

    foreach (['/', '/manga-anime', '/culture', '/voyage', '/cuisine', '/histoire', '/technologie', '/japonais', '/recherche', '/favoris', '/mentions-legales', '/confidentialite', '/sitemap.xml'] as $path) {
        $this->get($path)->assertOk();
    }
});

it('serves an article page', function () {
    $this->seed();

    $this->get('/articles/tokyo')->assertOk()->assertSee('Tokyo : mégalopole aux mille visages');
});

it('redirects legacy html routes permanently', function () {
    $this->seed();

    $this->get('/voyage.html')->assertStatus(301)->assertRedirect('/voyage');
    $this->get('/japonais.html')->assertStatus(301)->assertRedirect('/japonais');
});
