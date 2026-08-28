<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $fillable = [
        'category_id', 'legacy_id', 'legacy_url', 'title', 'slug', 'excerpt', 'body',
        'keywords', 'image_path', 'image_alt', 'is_featured', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'keywords' => 'array',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
