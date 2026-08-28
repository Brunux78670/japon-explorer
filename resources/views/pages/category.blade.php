<x-layouts.app :title="$category->name.' — Japon Explorer'" :description="$category->description">
    <section class="page-hero">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="eyebrow">Japon Explorer</p>
            <h1 class="mt-3 font-display text-4xl font-black tracking-tight text-white sm:text-6xl">{{ $category->name }}</h1>
            <p class="mt-5 max-w-3xl text-lg leading-8 text-slate-300">{{ $category->description }}</p>
        </div>
    </section>
    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($articles as $article)
                <x-article-card :article="$article" />
            @endforeach
        </div>
    </section>
</x-layouts.app>
