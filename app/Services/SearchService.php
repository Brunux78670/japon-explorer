<?php

namespace App\Services;

use App\Models\Article;
use App\Support\TextNormalizer;
use Illuminate\Support\Collection;

class SearchService
{
    public function search(string $query, int $limit = 12): Collection
    {
        $needle = TextNormalizer::normalize($query);
        if ($needle === '' || strlen($needle) < 2) {
            return collect();
        }

        return Article::query()
            ->with('category')
            ->whereNotNull('published_at')
            ->orderByDesc('is_featured')
            ->orderBy('title')
            ->get()
            ->filter(function (Article $article) use ($needle): bool {
                $haystack = TextNormalizer::normalize(implode(' ', [
                    $article->title,
                    $article->excerpt,
                    implode(' ', $article->keywords ?? []),
                    $article->category?->name ?? '',
                ]));

                return str_contains($haystack, $needle);
            })
            ->take($limit)
            ->values();
    }
}
