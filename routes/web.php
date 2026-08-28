<?php

use App\Http\Controllers\ContentController;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', [ContentController::class, 'home'])->name('home');
Route::get('/recherche', [ContentController::class, 'search'])->name('search');
Route::get('/favoris', [ContentController::class, 'favorites'])->name('favorites');
Route::get('/articles/{article:slug}', [ContentController::class, 'article'])->name('articles.show');
Route::get('/mentions-legales', [ContentController::class, 'legal'])->name('legal');
Route::get('/confidentialite', [ContentController::class, 'privacy'])->name('privacy');
Route::get('/sitemap.xml', function () {
    return response()->view('sitemap', [
        'categories' => Category::query()->orderBy('sort_order')->get(),
        'articles' => Article::query()->whereNotNull('published_at')->orderBy('slug')->get(),
    ])->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');

$categoryPattern = 'manga-anime|culture|voyage|cuisine|histoire|technologie|japonais';
Route::get('/{category:slug}', [ContentController::class, 'category'])
    ->where('category', $categoryPattern)
    ->name('category.show');

Route::redirect('/manga-anime.html', '/manga-anime', 301);
Route::redirect('/culture.html', '/culture', 301);
Route::redirect('/voyage.html', '/voyage', 301);
Route::redirect('/cuisine.html', '/cuisine', 301);
Route::redirect('/histoire.html', '/histoire', 301);
Route::redirect('/technologie.html', '/technologie', 301);
Route::redirect('/japonais.html', '/japonais', 301);
Route::redirect('/recherche.html', '/recherche', 301);
Route::redirect('/favoris.html', '/favoris', 301);
Route::redirect('/mentions-legales.html', '/mentions-legales', 301);
Route::redirect('/confidentialite.html', '/confidentialite', 301);
Route::redirect('/index.html', '/', 301);
