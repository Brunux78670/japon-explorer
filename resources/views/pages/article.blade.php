<x-layouts.app :title="$article->title.' — Japon Explorer'" :description="$article->excerpt">
    <article>
        <header class="page-hero">
            <div class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
                <a class="eyebrow hover:text-white" href="{{ route('category.show', ['category' => $article->category->slug]) }}">{{ $article->category->name }}</a>
                <h1 class="mt-4 font-display text-4xl font-black tracking-tight text-white sm:text-6xl">{{ $article->title }}</h1>
                <p class="mt-5 text-lg leading-8 text-slate-300">{{ $article->excerpt }}</p>
                @if ($article->keywords)
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach ($article->keywords as $keyword)<span class="tag">{{ $keyword }}</span>@endforeach
                    </div>
                @endif
            </div>
        </header>
        <div class="mx-auto grid max-w-4xl gap-8 px-4 py-12 sm:px-6 lg:px-8">
            @if ($article->image_path)
                <img src="{{ asset(ltrim($article->image_path, '/')) }}" alt="{{ $article->image_alt ?: '' }}" class="w-full rounded-3xl border border-white/10 bg-white/5" loading="eager">
            @endif
            <div class="prose-japan">{!! nl2br(e($article->body)) !!}</div>
            <a class="btn-secondary w-fit" href="{{ route('category.show', ['category' => $article->category->slug]) }}">← Retour à {{ $article->category->name }}</a>
        </div>
    </article>
</x-layouts.app>
