@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ route('home') }}</loc></url>
    @foreach ($categories as $category)
        <url><loc>{{ route('category.show', ['category' => $category->slug]) }}</loc></url>
    @endforeach
    @foreach ($articles as $article)
        <url>
            <loc>{{ route('articles.show', ['article' => $article->slug]) }}</loc>
            @if ($article->published_at)<lastmod>{{ $article->published_at->toDateString() }}</lastmod>@endif
        </url>
    @endforeach
    <url><loc>{{ route('legal') }}</loc></url>
    <url><loc>{{ route('privacy') }}</loc></url>
</urlset>
