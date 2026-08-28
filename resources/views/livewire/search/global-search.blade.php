<div>
    <label for="global-search" class="sr-only">Rechercher dans Japon Explorer</label>
    <div class="relative">
        <input id="global-search" type="search" wire:model.live.debounce.250ms="query" autocomplete="off"
               placeholder="Ex. Tokyo, ramen, shōnen, hiragana…"
               class="w-full rounded-2xl border border-white/10 bg-white/[0.055] px-5 py-4 pr-12 text-base text-white shadow-xl shadow-black/10 outline-none placeholder:text-slate-500 focus:border-sakura/50 focus:ring-2 focus:ring-sakura/25">
        <span class="pointer-events-none absolute right-5 top-1/2 -translate-y-1/2 text-xl text-slate-500" aria-hidden="true">⌕</span>
    </div>

    <div class="mt-8" aria-live="polite" aria-busy="{{ $this->query !== '' ? 'false' : 'false' }}">
        @if (trim($query) === '')
            <div class="card-surface p-8 text-center text-slate-400">Saisis au moins deux caractères pour lancer la recherche.</div>
        @elseif (mb_strlen(trim($query)) < 2)
            <div class="card-surface p-8 text-center text-slate-400">Ajoute encore un caractère.</div>
        @else
            <p class="mb-4 text-sm text-slate-400">{{ $results->count() }} résultat{{ $results->count() > 1 ? 's' : '' }} pour « {{ $query }} »</p>
            <div class="grid gap-4 md:grid-cols-2">
                @forelse ($results as $article)
                    <a href="{{ route('articles.show', ['article' => $article->slug]) }}" class="card-surface group p-5 transition hover:-translate-y-1 hover:border-sakura/30">
                        <span class="eyebrow">{{ $article->category->name }}</span>
                        <span class="mt-2 block font-display text-lg font-bold text-white group-hover:text-sakura">{{ $article->title }}</span>
                        <span class="mt-2 block text-sm leading-6 text-slate-400">{{ $article->excerpt }}</span>
                    </a>
                @empty
                    <div class="card-surface col-span-full p-8 text-center">
                        <p class="font-semibold text-white">Aucun résultat</p>
                        <p class="mt-2 text-sm text-slate-400">Essaie un mot plus simple ou une autre orthographe.</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>
