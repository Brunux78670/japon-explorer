<x-layouts.app title="Favoris — Japon Explorer" description="Retrouvez vos fiches Japon Explorer favorites." robots="noindex,follow">
    <section class="page-hero">
        <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="eyebrow">Ma sélection</p>
            <h1 class="mt-3 font-display text-4xl font-black text-white sm:text-6xl">Mes favoris</h1>
            <p class="mt-5 text-lg text-slate-300">Tes favoris sont enregistrés localement dans ce navigateur, sans compte utilisateur.</p>
        </div>
    </section>
    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3" data-favorites-page>
            <div data-favorites-empty class="card-surface col-span-full p-8 text-center">
                <p class="font-semibold text-white">Aucun favori pour l’instant</p>
                <p class="mt-2 text-sm text-slate-400">Clique sur ♡ sur une fiche pour la retrouver ici.</p>
                <a href="{{ route('home') }}" class="btn-secondary mt-5">Explorer les rubriques</a>
            </div>
            @foreach ($articles as $article)
                <div data-favorite-card data-favorite-slug="{{ $article->slug }}" hidden>
                    <x-article-card :article="$article" />
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.app>
