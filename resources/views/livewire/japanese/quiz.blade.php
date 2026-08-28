<div class="card-surface overflow-hidden p-6 sm:p-8" aria-live="polite">
    @if ($total === 0)
        <p class="text-slate-300">Le quiz n’est pas encore disponible.</p>
    @elseif ($finished)
        <div class="text-center">
            <p class="eyebrow">Terminé</p>
            <h3 class="mt-3 font-display text-3xl font-black text-white">{{ $score }} / {{ $total }}</h3>
            <p class="mt-3 text-slate-300">
                @if ($score === $total)
                    Parfait ! Tes premiers repères sont solides. 🎌
                @elseif ($score >= ceil($total * .6))
                    Bien joué ! Encore un passage et ça sera encore plus fluide.
                @else
                    Bonne première étape : relis les fiches kana puis retente le quiz.
                @endif
            </p>
            <button type="button" wire:click="restart" class="btn-primary mt-6">Recommencer</button>
        </div>
    @elseif ($question)
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="eyebrow">Question {{ $currentIndex + 1 }} / {{ $total }}</p>
            <p class="text-sm font-semibold text-slate-400">Score : {{ $score }}</p>
        </div>
        <h3 class="mt-5 font-display text-2xl font-bold leading-snug text-white">{{ $question->prompt }}</h3>

        <div class="mt-6 grid gap-3 sm:grid-cols-2" role="group" aria-label="Choix de réponse">
            @foreach ($question->choices as $index => $choice)
                <button type="button" wire:click="answer({{ $index }})" @disabled($answered)
                        class="rounded-xl border p-4 text-left text-sm font-semibold transition
                            {{ $answered && $selected === $index
                                ? ($correct ? 'border-emerald-400/60 bg-emerald-400/10 text-emerald-100' : 'border-rose-400/60 bg-rose-400/10 text-rose-100')
                                : 'border-white/10 bg-white/[0.035] text-slate-200 hover:border-sakura/35 hover:bg-white/[0.065]' }}
                            disabled:cursor-default">
                    {{ $choice }}
                </button>
            @endforeach
        </div>

        @if ($answered)
            <div class="mt-6 rounded-xl border {{ $correct ? 'border-emerald-400/30 bg-emerald-400/10' : 'border-rose-400/30 bg-rose-400/10' }} p-4">
                <p class="font-bold {{ $correct ? 'text-emerald-200' : 'text-rose-200' }}">{{ $correct ? 'Bonne réponse !' : 'Pas cette fois.' }}</p>
                @if ($explanation)<p class="mt-1 text-sm leading-6 text-slate-300">{{ $explanation }}</p>@endif
            </div>
            <button type="button" wire:click="next" class="btn-primary mt-6">{{ $currentIndex + 1 >= $total ? 'Voir mon score' : 'Question suivante' }}</button>
        @endif
    @endif
</div>
