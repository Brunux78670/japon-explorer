# Japon Explorer Laravel Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Migrer Japon Explorer V1 vers une application Laravel 13 moderne, pilotée par base de données, Blade/Livewire, sans perte des 40 contenus existants.

**Architecture:** Laravel conventionnel avec Blade pour les pages éditoriales, Livewire 4 pour recherche/quiz, Eloquent pour catégories/articles/questions et une petite couche JavaScript locale pour les favoris anonymes. La V1 est archivée dans `legacy-v1/` et les données de seed sont déterministes.

**Tech Stack:** PHP 8.5 cible (PHP >=8.3 compatible), Laravel 13, Livewire 4, Tailwind CSS 4.3, Vite, Alpine.js, SQLite/MySQL, Pest, Pint.

**Spec:** `docs/superpowers/specs/2026-08-27-site-japon-laravel-design.md`

## Global Constraints

- Conserver les 40 contenus V1 et les 7 catégories principales.
- Conserver l'identité sombre bleu-noir, rouge japonais et rose sakura.
- Routes publiques sans extension `.html`, avec redirections 301 des anciennes routes.
- Favoris visiteurs en `localStorage`, sans doublons.
- Recherche accent-insensitive sur titre, extrait, mots-clés et catégorie.
- Quiz japonais avec correction immédiate, score et explication.
- Blade échappe les contenus par défaut ; aucun secret dans Git.
- SQLite par défaut, compatibilité MySQL/MariaDB.
- Les pages principales doivent rester responsive et accessibles au clavier.

---

### Task 1: Baseline V1 et squelette Laravel
**Files:** `legacy-v1/**`, `composer.json`, `artisan`, `bootstrap/app.php`, `config/**`, `.env.example`, `package.json`, `vite.config.js`
**Interfaces:** Produit une structure Laravel 13 installable par `composer install` et `npm install`.
- [ ] Archiver le ZIP V1 sous `legacy-v1/` avec ses 40 fichiers runtime.
- [ ] Ajouter un test structurel qui vérifie les fichiers Laravel fondamentaux et les contraintes de version.
- [ ] Vérifier que le test échoue avant création du squelette.
- [ ] Créer le squelette source Laravel 13 minimal et les manifestes de dépendances.
- [ ] Vérifier le test structurel puis commit.

### Task 2: Jeu de données déterministe
**Files:** `database/data/articles.php`, `database/data/quiz.php`, `tests/source/content-data.test.mjs`
**Interfaces:** Produit exactement 40 articles structurés avec `category`, `title`, `slug`, `excerpt`, `body`, `keywords`, `image_path`, `is_featured`.
- [ ] Écrire le test Node qui exige 40 slugs uniques et 7 catégories.
- [ ] Vérifier l'échec initial.
- [ ] Convertir `legacy-v1/assets/js/content.js` en données PHP déterministes.
- [ ] Vérifier 40/40 et commit.

### Task 3: Schéma Eloquent et seeders
**Files:** `app/Models/*.php`, `database/migrations/*.php`, `database/seeders/*.php`, `tests/source/schema.test.mjs`
**Interfaces:** `Category::articles()`, `Article::category()`, `QuizQuestion` casts JSON, `Favorite::article()`.
- [ ] Écrire les assertions structurelles migrations/modèles.
- [ ] Vérifier l'échec.
- [ ] Créer migrations, modèles, seeders idempotents.
- [ ] Vérifier syntaxe PHP et structure, commit.

### Task 4: Routes et contrôleur de contenu
**Files:** `routes/web.php`, `app/Http/Controllers/ContentController.php`, `tests/source/routes.test.mjs`
**Interfaces:** `home()`, `category(Category $category)`, `article(Article $article)`, pages légales.
- [ ] Tester les 12 routes principales, la route article et les redirections legacy.
- [ ] Vérifier l'échec.
- [ ] Implémenter les routes nommées et bindings.
- [ ] Vérifier les tests et commit.

### Task 5: Layout Blade et composants partagés
**Files:** `resources/views/layouts/app.blade.php`, `resources/views/components/*.blade.php`, `resources/views/pages/*.blade.php`
**Interfaces:** layout accepte `$title`, `$description`, `$robots`; composants `article-card`, `header`, `footer`, `section-heading`.
- [ ] Tester présence landmarks, skip-link, meta et composants.
- [ ] Vérifier l'échec.
- [ ] Implémenter layout/composants et pages.
- [ ] Vérifier et commit.

### Task 6: Design Tailwind/Vite
**Files:** `resources/css/app.css`, `resources/js/app.js`, `tailwind.config.js` si nécessaire, `vite.config.js`
**Interfaces:** classes de design Japon, responsive, focus visible, reduced motion.
- [ ] Tester les tokens/classes attendus et manifests Vite/Tailwind.
- [ ] Vérifier l'échec.
- [ ] Implémenter styles et micro-interactions Alpine.
- [ ] Vérifier tests source et commit.

### Task 7: Pages catégories et article
**Files:** `resources/views/pages/home.blade.php`, `category.blade.php`, `article.blade.php`, `app/Http/Controllers/ContentController.php`
**Interfaces:** catégories chargées depuis DB, cartes liées à `articles.show`.
- [ ] Tester que vues consomment données dynamiques, sans dupliquer 7 templates.
- [ ] Vérifier l'échec.
- [ ] Implémenter les vues dynamiques.
- [ ] Vérifier et commit.

### Task 8: Recherche Livewire
**Files:** `app/Livewire/Search/GlobalSearch.php`, `app/Services/SearchService.php`, `resources/views/livewire/search/global-search.blade.php`, `resources/views/pages/search.blade.php`
**Interfaces:** `SearchService::search(string $query, int $limit = 12)`, composant propriété `$query`.
- [ ] Tester structure Livewire et normalisation accent/casse.
- [ ] Vérifier l'échec.
- [ ] Implémenter service et composant avec debounce.
- [ ] Vérifier et commit.

### Task 9: Favoris anonymes
**Files:** `resources/js/favorites.js`, `resources/views/components/favorite-button.blade.php`, `resources/views/pages/favorites.blade.php`
**Interfaces:** API JS `readFavorites`, `toggleFavorite`, `isFavorite`, événement `japon:favorite-changed`.
- [ ] Écrire tests Node sur absence de doublons et bascule ajout/suppression.
- [ ] Vérifier l'échec.
- [ ] Implémenter module JS et composants.
- [ ] Vérifier et commit.

### Task 10: Quiz Livewire
**Files:** `app/Livewire/Japanese/Quiz.php`, `resources/views/livewire/japanese/quiz.blade.php`, `resources/views/pages/japanese.blade.php`
**Interfaces:** `answer(string $choice)`, `next()`, `restart()`, score/progression publics.
- [ ] Tester structure et logique de score via helper pur de données si dépendances Laravel indisponibles.
- [ ] Vérifier l'échec.
- [ ] Implémenter composant et vue accessible.
- [ ] Vérifier et commit.

### Task 11: SEO, sitemap, robots et redirections
**Files:** `routes/web.php`, `routes/console.php`, `public/robots.txt`, `resources/views/sitemap.blade.php`
**Interfaces:** route `sitemap`, redirections 301 `/x.html` -> `/x`.
- [ ] Tester titres/meta/robots/sitemap/redirections définies.
- [ ] Vérifier l'échec.
- [ ] Implémenter.
- [ ] Vérifier et commit.

### Task 12: Sécurité et configuration
**Files:** `.env.example`, `config/session.php`, `bootstrap/app.php`, `app/Providers/AppServiceProvider.php`
**Interfaces:** aucune clé réelle, cookies configurables sécurisés, middleware Laravel standard.
- [ ] Tester absence de secrets et échappement des vues.
- [ ] Vérifier l'échec.
- [ ] Finaliser configuration sécurisée.
- [ ] Vérifier et commit.

### Task 13: Tests Laravel/Pest
**Files:** `tests/Feature/*.php`, `tests/Unit/*.php`, `tests/Pest.php`, `phpunit.xml`
**Interfaces:** tests feature routes, contenu 40, recherche, quiz.
- [ ] Créer les tests Pest destinés à s'exécuter après `composer install`.
- [ ] Vérifier syntaxe PHP localement.
- [ ] Documenter la commande `php artisan test` et prérequis extensions.
- [ ] Commit.

### Task 14: Documentation et scripts de validation
**Files:** `README.md`, `scripts/verify-source.mjs`, `scripts/package.sh`
**Interfaces:** installation Ubuntu/Windows/macOS, SQLite/MySQL, build/dev.
- [ ] Tester que README contient toutes les commandes nécessaires.
- [ ] Écrire script de validation hors dépendances.
- [ ] Exécuter validation source et commit.

### Task 15: Paquet final et vérification
**Files:** `dist/site-japon-laravel-source.zip`
**Interfaces:** archive sans `.git`, `.env`, `vendor`, `node_modules`.
- [ ] Exécuter tous les tests source et `php -l` sur les fichiers PHP.
- [ ] Si les dépendances sont disponibles, exécuter `composer install`, `php artisan migrate:fresh --seed`, `php artisan test`, `vendor/bin/pint --test`, `npm install`, `npm run build`.
- [ ] Sinon, consigner explicitement les vérifications non exécutables dans `BUILD-STATUS.md`.
- [ ] Générer le ZIP et vérifier son contenu.
- [ ] Commit final.
