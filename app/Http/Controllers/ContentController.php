<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\View\View;

class ContentController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'categories' => Category::query()->withCount('articles')->orderBy('sort_order')->get(),
            'featuredArticles' => Article::query()->with('category')->where('is_featured', true)->orderBy('title')->get(),
        ]);
    }

    public function category(Category $category): View
    {
        $category->load(['articles' => fn ($query) => $query->whereNotNull('published_at')]);

        return view($category->slug === 'japonais' ? 'pages.japanese' : 'pages.category', [
            'category' => $category,
            'articles' => $category->articles,
        ]);
    }

    public function article(Article $article): View
    {
        $article->load('category');

        return view('pages.article', ['article' => $article]);
    }

    public function search(): View
    {
        return view('pages.search');
    }

    public function favorites(): View
    {
        return view('pages.favorites', [
            'articles' => Article::query()->with('category')->whereNotNull('published_at')->orderBy('title')->get(),
        ]);
    }

    public function legal(): View
    {
        return view('pages.legal');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }
}
