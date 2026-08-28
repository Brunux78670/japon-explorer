<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Manga & Anime', 'slug' => 'manga-anime', 'description' => 'Manga, anime, genres et repères de la pop culture japonaise.', 'sort_order' => 10],
            ['name' => 'Culture', 'slug' => 'culture', 'description' => 'Traditions, arts, spiritualités et étiquette au Japon.', 'sort_order' => 20],
            ['name' => 'Voyage', 'slug' => 'voyage', 'description' => 'Destinations, transports et idées pour découvrir le Japon.', 'sort_order' => 30],
            ['name' => 'Cuisine', 'slug' => 'cuisine', 'description' => 'Plats, boissons et spécialités de la gastronomie japonaise.', 'sort_order' => 40],
            ['name' => 'Histoire', 'slug' => 'histoire', 'description' => 'Des premières périodes au Japon contemporain.', 'sort_order' => 50],
            ['name' => 'Technologie', 'slug' => 'technologie', 'description' => 'Transports, robotique, jeu vidéo et industrie.', 'sort_order' => 60],
            ['name' => 'Japonais', 'slug' => 'japonais', 'description' => 'Hiragana, katakana, kanji et premières expressions.', 'sort_order' => 70],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
