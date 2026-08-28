@props([
    'title' => 'Japon Explorer',
    'description' => 'Découvrez le Japon : culture, manga, anime, voyage, cuisine, histoire, technologie et langue japonaise.',
    'robots' => 'index,follow',
])
<!doctype html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description }}">
    <meta name="robots" content="{{ $robots }}">
    <meta name="theme-color" content="#070b14">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/hero-japan.svg') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-ink text-slate-100 antialiased selection:bg-japan-red/40 selection:text-white">
    <a class="skip-link" href="#contenu">Aller au contenu</a>
    <div class="site-glow" aria-hidden="true"></div>
    <x-header />
    <main id="contenu" class="relative z-10 min-h-[70vh]">
        {{ $slot }}
    </main>
    <x-footer />
    @livewireScripts
</body>
</html>
