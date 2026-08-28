@props(['article'])
<article class="group card-surface flex h-full flex-col overflow-hidden">
    @if ($article->image_path)
        <div class="relative aspect-[16/9] overflow-hidden border-b border-white/10 bg-white/5">
            <img src="{{ asset(ltrim($article->image_path, '/')) }}" alt="{{ $article->image_alt ?: '' }}"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]" loading="lazy">
            @if ($article->is_featured)
                <span class="absolute left-3 top-3 rounded-full bg-japan-red px-3 py-1 text-xs font-bold text-white shadow">À découvrir</span>
            @endif
        </div>
    @endif
    <div class="flex flex-1 flex-col p-5">
        <a href="{{ route('category.show', ['category' => $article->category->slug]) }}" class="eyebrow hover:text-white">{{ $article->category->name }}</a>
        <h3 class="mt-2 font-display text-xl font-bold text-white">
            <a href="{{ route('articles.show', ['article' => $article->slug]) }}" class="rounded focus:outline-none focus-visible:ring-2 focus-visible:ring-sakura">{{ $article->title }}</a>
        </h3>
        <p class="mt-3 flex-1 text-sm leading-6 text-slate-300">{{ $article->excerpt }}</p>
        <div class="mt-5 flex items-center justify-between gap-3">
            <a href="{{ route('articles.show', ['article' => $article->slug]) }}" class="text-link">Lire la fiche <span aria-hidden="true">→</span></a>
            <x-favorite-button :article="$article" />
        </div>
    </div>
</article>
