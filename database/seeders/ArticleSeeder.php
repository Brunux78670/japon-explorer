<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Seeder;
use RuntimeException;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::query()->pluck('id', 'slug');

        foreach (require database_path('data/articles.php') as $item) {
            $categoryId = $categoryIds[$item['category']] ?? null;
            if (! $categoryId) {
                throw new RuntimeException("Catégorie inconnue: {$item['category']}");
            }

            Article::query()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $categoryId,
                    'legacy_id' => $item['legacy_id'],
                    'legacy_url' => $item['legacy_url'],
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'body' => $item['body'],
                    'keywords' => $item['keywords'],
                    'image_path' => $item['image_path'],
                    'image_alt' => $item['image_alt'],
                    'is_featured' => $item['is_featured'],
                    'published_at' => $item['published_at'],
                ],
            );
        }
    }
}
