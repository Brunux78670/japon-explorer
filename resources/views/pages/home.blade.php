<x-layouts.app title="Japon Explorer — Découvrir le Japon" description="Culture, manga, anime, voyage, cuisine, histoire, technologie et japonais : explorez le Japon en français.">
    <section class="relative overflow-hidden border-b border-white/10">
        <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-16 sm:px-6 md:py-24 lg:grid-cols-[1.05fr_.95fr] lg:px-8 lg:py-28">
            <div>
                <p class="eyebrow">Bienvenue au Japon</p>
                <h1 class="mt-4 max-w-3xl font-display text-5xl font-black tracking-tight text-white sm:text-6xl lg:text-7xl">Explore le Japon, <span class="text-gradient">bien au-delà des clichés.</span></h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">Manga et anime, temples de Kyoto, rues de Tokyo, cuisine, histoire, innovations et premiers kana : Japon Explorer rassemble les repères essentiels dans un site clair et vivant.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a class="btn-primary" href="{{ route('category.show', ['category' => 'voyage']) }}">Préparer un voyage</a>
                    <a class="btn-secondary" href="{{ route('category.show', ['category' => 'manga-anime']) }}">Explorer manga & anime</a>
                </div>
            </div>
            <div class="relative mx-auto w-full max-w-xl">
                <div class="hero-orbit" aria-hidden="true"></div>
                <img src="{{ asset('images/hero-japan.svg') }}" alt="Illustration stylisée du Japon" class="relative z-10 w-full drop-shadow-2xl">
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <x-section-heading eyebrow="7 univers" title="Choisis ta porte d’entrée" text="Chaque rubrique s’appuie désormais sur une base de données Laravel : le contenu peut évoluer sans recopier des pages entières." />
        <div class="mt-9 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($categories as $category)
                <a href="{{ route('category.show', ['category' => $category->slug]) }}" class="category-tile group">
                    <span class="text-2xl" aria-hidden="true">{{ match($category->slug) { 'manga-anime' => '🎌', 'culture' => '⛩️', 'voyage' => '🗾', 'cuisine' => '🍜', 'histoire' => '🏯', 'technologie' => '🤖', default => 'あ' } }}</span>
                    <span class="mt-5 block font-display text-xl font-bold text-white group-hover:text-sakura">{{ $category->name }}</span>
                    <span class="mt-2 block text-sm leading-6 text-slate-400">{{ $category->description }}</span>
                    <span class="mt-4 inline-flex text-xs font-semibold text-slate-500">{{ $category->articles_count }} fiches</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="border-y border-white/10 bg-white/[0.025]">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Sélection" title="Commence par ces essentiels" text="Sept fiches mises en avant, une dans chaque grand univers de Japon Explorer." />
            <div class="mt-9 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($featuredArticles as $article)
                    <x-article-card :article="$article" />
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
