@props(['eyebrow' => null, 'title', 'text' => null, 'align' => 'left'])
<div class="{{ $align === 'center' ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl' }}">
    @if ($eyebrow)<p class="eyebrow">{{ $eyebrow }}</p>@endif
    <h2 class="mt-2 font-display text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ $title }}</h2>
    @if ($text)<p class="mt-4 text-base leading-7 text-slate-300 sm:text-lg">{{ $text }}</p>@endif
</div>
