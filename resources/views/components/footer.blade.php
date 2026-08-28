<footer class="relative z-10 mt-20 border-t border-white/10 bg-black/20">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-3 lg:px-8">
        <div>
            <p class="font-display text-xl font-bold text-white">Japon Explorer</p>
            <p class="mt-2 max-w-sm text-sm leading-6 text-slate-400">Un portail francophone pour explorer la culture japonaise, préparer un voyage et apprendre les premiers repères de la langue.</p>
        </div>
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sakura">Explorer</p>
            <div class="mt-3 flex flex-wrap gap-x-4 gap-y-2 text-sm text-slate-300">
                <a class="footer-link" href="{{ route('category.show', ['category' => 'manga-anime']) }}">Manga & Anime</a>
                <a class="footer-link" href="{{ route('category.show', ['category' => 'voyage']) }}">Voyage</a>
                <a class="footer-link" href="{{ route('category.show', ['category' => 'japonais']) }}">Japonais</a>
            </div>
        </div>
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sakura">Informations</p>
            <div class="mt-3 flex flex-col gap-2 text-sm text-slate-300">
                <a class="footer-link" href="{{ route('legal') }}">Mentions légales</a>
                <a class="footer-link" href="{{ route('privacy') }}">Confidentialité</a>
            </div>
        </div>
    </div>
    <div class="border-t border-white/5 py-5 text-center text-xs text-slate-500">© {{ now()->year }} Japon Explorer — fait avec Laravel et beaucoup de curiosité 🇯🇵</div>
</footer>
