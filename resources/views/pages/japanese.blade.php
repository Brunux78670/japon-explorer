<x-layouts.app title="Apprendre le japonais — Japon Explorer" :description="$category->description">
    <section class="page-hero">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="eyebrow">日本語 • Nihongo</p>
            <h1 class="mt-3 font-display text-4xl font-black text-white sm:text-6xl">Premiers pas en japonais</h1>
            <p class="mt-5 max-w-3xl text-lg leading-8 text-slate-300">{{ $category->description }} Découvre les systèmes d’écriture puis entraîne-toi avec le quiz interactif.</p>
        </div>
    </section>
    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($articles as $article)<x-article-card :article="$article" />@endforeach
        </div>
        <div class="mt-14" id="quiz-japonais">
            <x-section-heading eyebrow="Mini quiz" title="Teste tes premiers repères" text="Huit questions courtes avec correction immédiate." />
            <div class="mt-7"><livewire:japanese.quiz /></div>
        </div>
    </section>
</x-layouts.app>
