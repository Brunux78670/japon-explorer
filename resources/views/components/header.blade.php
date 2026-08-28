@php
    $nav = [
        'manga-anime' => 'Manga & Anime', 'culture' => 'Culture', 'voyage' => 'Voyage',
        'cuisine' => 'Cuisine', 'histoire' => 'Histoire', 'technologie' => 'Technologie', 'japonais' => 'Japonais',
    ];
@endphp
<header x-data="{ open: false }" class="sticky top-0 z-50 border-b border-white/10 bg-ink/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="group flex min-w-0 items-center gap-3 rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-sakura">
            <span class="grid size-10 shrink-0 place-items-center rounded-full bg-japan-red text-lg font-black shadow-lg shadow-japan-red/20">日</span>
            <span class="min-w-0">
                <span class="block truncate font-display text-lg font-bold tracking-tight text-white">Japon Explorer</span>
                <span class="hidden text-xs text-slate-400 sm:block">日本をもっと近くに</span>
            </span>
        </a>

        <nav class="ml-auto hidden items-center gap-1 xl:flex" aria-label="Navigation principale">
            @foreach ($nav as $slug => $label)
                <a href="{{ route('category.show', ['category' => $slug]) }}"
                   class="nav-link {{ request()->is($slug) ? 'nav-link-active' : '' }}">{{ $label }}</a>
            @endforeach
        </nav>

        <div class="ml-auto flex items-center gap-2 xl:ml-2">
            <a href="{{ route('search') }}" class="icon-link" aria-label="Rechercher" title="Rechercher">
                <span aria-hidden="true">⌕</span>
            </a>
            <a href="{{ route('favorites') }}" class="icon-link" aria-label="Favoris" title="Favoris">
                <span aria-hidden="true">♡</span>
            </a>
            <button type="button" class="icon-link xl:hidden" @click="open = !open"
                    :aria-expanded="open.toString()" aria-controls="menu-mobile" aria-label="Ouvrir le menu">
                <span x-show="!open" aria-hidden="true">☰</span><span x-show="open" x-cloak aria-hidden="true">✕</span>
            </button>
        </div>
    </div>

    <nav id="menu-mobile" x-show="open" x-cloak @click.outside="open = false"
         class="border-t border-white/10 px-4 py-4 xl:hidden" aria-label="Navigation mobile">
        <div class="mx-auto grid max-w-7xl gap-2 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($nav as $slug => $label)
                <a href="{{ route('category.show', ['category' => $slug]) }}" class="mobile-nav-link">{{ $label }}</a>
            @endforeach
        </div>
    </nav>
</header>
