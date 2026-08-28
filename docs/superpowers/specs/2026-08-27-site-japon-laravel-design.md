# Japon Explorer — Refonte Laravel moderne

Date : 2026-08-27
Statut : conception approuvée en conversation, à relire avant plan d’implémentation

## 1. Objectif

Transformer la V1 statique de Japon Explorer en une application web PHP moderne, maintenable et évolutive, sans perdre le contenu ni l’identité visuelle existants.

La V2 doit conserver l’esprit du portail actuel consacré au Japon — manga et anime, culture, voyage, cuisine, histoire, technologie et apprentissage du japonais — tout en ajoutant une vraie architecture applicative, une base de données, des composants dynamiques et une fondation prête pour de futures fonctionnalités comme les comptes, l’administration, les commentaires et les contenus éditoriaux enrichis.

## 2. Stack technique retenue

### Backend

- PHP 8.5, branche stable et activement maintenue au moment de cette spécification.
- Laravel 13.x.
- Eloquent ORM.
- Blade pour les vues serveur.
- Livewire 4 pour les interactions dynamiques principalement pilotées côté PHP.
- Validation Laravel, CSRF, middleware et protections natives du framework.

### Frontend

- Tailwind CSS 4.3.
- Vite pour les assets CSS/JavaScript.
- Alpine.js seulement lorsqu’une micro-interaction locale est plus simple qu’un aller-retour Livewire.
- SVG locaux et assets optimisés pour les illustrations actuelles.

### Données

- SQLite par défaut pour le développement local et le démarrage rapide.
- Compatibilité MySQL/MariaDB pour un hébergement de production.
- Migrations Laravel pour versionner le schéma.
- Seeders pour importer le contenu actuel de la V1.

### Tests et qualité

- Pest pour les tests unitaires et feature.
- Tests Livewire pour les composants interactifs.
- Laravel Pint pour le style PHP.
- Tests de build Vite.

## 3. Principes d’architecture

La V2 adopte une architecture Laravel classique, volontairement simple :

- les modèles représentent les données persistées ;
- les actions métier répétables sont isolées dans des services ciblés ;
- les pages de contenu essentiellement éditoriales utilisent Blade ;
- les zones interactives utilisent Livewire ;
- les composants d’interface réutilisables vivent dans des Blade Components ;
- aucune SPA React/Vue n’est introduite ;
- JavaScript personnalisé reste limité aux comportements réellement plus efficaces côté navigateur.

Le projet privilégie la lisibilité, les conventions Laravel et YAGNI plutôt qu’une architecture complexe en couches artificielles.

## 4. Arborescence cible

```text
app/
├── Livewire/
│   ├── Favorites/
│   │   └── FavoriteList.php
│   ├── Japanese/
│   │   └── Quiz.php
│   └── Search/
│       └── GlobalSearch.php
├── Models/
│   ├── Article.php
│   ├── Category.php
│   ├── Favorite.php
│   └── QuizQuestion.php
├── Services/
│   ├── ContentImportService.php
│   └── SearchService.php
└── Http/
    └── Controllers/
        └── ContentController.php

database/
├── factories/
├── migrations/
└── seeders/
    ├── CategorySeeder.php
    ├── ArticleSeeder.php
    ├── QuizQuestionSeeder.php
    └── DatabaseSeeder.php

resources/
├── css/
│   └── app.css
├── js/
│   └── app.js
└── views/
    ├── components/
    │   ├── article-card.blade.php
    │   ├── badge.blade.php
    │   ├── footer.blade.php
    │   ├── header.blade.php
    │   └── section-heading.blade.php
    ├── layouts/
    │   └── app.blade.php
    ├── livewire/
    │   ├── favorites/
    │   ├── japanese/
    │   └── search/
    └── pages/
        ├── home.blade.php
        ├── category.blade.php
        ├── japonais.blade.php
        ├── mentions-legales.blade.php
        └── confidentialite.blade.php

routes/
└── web.php

tests/
├── Feature/
├── Unit/
└── Pest.php
```

## 5. Modèle de données

### categories

- `id`
- `name`
- `slug` unique
- `description` nullable
- `sort_order` integer
- timestamps

Catégories initiales :

- manga-anime
- culture
- voyage
- cuisine
- histoire
- technologie
- japonais

### articles

- `id`
- `category_id` foreign key
- `title`
- `slug` unique
- `excerpt`
- `body` long text
- `keywords` JSON
- `image_path` nullable
- `image_alt` nullable
- `is_featured` boolean
- `published_at` nullable
- timestamps

Le champ `body` contient du contenu éditorial contrôlé par l’application. L’affichage doit éviter l’injection arbitraire de HTML provenant d’un utilisateur.

### quiz_questions

- `id`
- `prompt`
- `choices` JSON
- `correct_answer`
- `explanation` nullable
- `sort_order`
- timestamps

### favorites

La table est créée dès la V2 pour préparer les comptes utilisateurs, mais l’authentification complète n’est pas obligatoire dans la première migration fonctionnelle.

- `id`
- `user_id` nullable dans la phase transitoire si nécessaire
- `article_id`
- timestamps
- contrainte d’unicité sur la paire utilisateur/article lorsque l’authentification est activée

Tant qu’aucun compte n’est connecté, les favoris restent disponibles en `localStorage`. Une couche d’abstraction permet ensuite de synchroniser les favoris lors de l’ajout de l’authentification.

## 6. Routes publiques

Routes principales :

```text
GET  /
GET  /manga-anime
GET  /culture
GET  /voyage
GET  /cuisine
GET  /histoire
GET  /technologie
GET  /japonais
GET  /recherche
GET  /favoris
GET  /articles/{article:slug}
GET  /mentions-legales
GET  /confidentialite
```

Les pages de catégorie chargent les articles associés depuis la base et utilisent un même template afin d’éviter la duplication actuelle entre fichiers HTML.

## 7. Migration du contenu V1

La V1 contient déjà un catalogue structuré de 40 éléments dans `assets/js/content.js` et `assets/data/search-index.json`.

La migration doit :

1. extraire les catégories et articles existants ;
2. créer des seeders déterministes ;
3. conserver les titres, résumés, mots-clés et ancres utiles ;
4. enrichir progressivement les corps de contenu à partir des pages HTML actuelles ;
5. réutiliser les SVG locaux existants lorsque cela reste pertinent ;
6. conserver une correspondance entre les anciens identifiants et les nouveaux slugs.

Aucune donnée éditoriale existante ne doit être supprimée simplement parce qu’elle vient de la V1 statique.

## 8. Compatibilité des anciennes URL

Les anciennes URLs en `.html` doivent rediriger en 301 vers les routes Laravel correspondantes lorsque le serveur de production permet ces redirections.

Exemples :

```text
/manga-anime.html  -> /manga-anime
/voyage.html       -> /voyage
/japonais.html     -> /japonais
/recherche.html    -> /recherche
/favoris.html      -> /favoris
```

Les ancres historiques importantes doivent être conservées lorsqu’elles pointent encore vers une section pertinente.

## 9. Recherche moderne

La recherche est implémentée par un composant Livewire `GlobalSearch`.

### Comportement

- recherche réactive après une courte temporisation ;
- recherche insensible à la casse ;
- normalisation des accents pour améliorer les correspondances ;
- champs interrogés : titre, extrait, mots-clés et catégorie ;
- résultats cliquables vers les pages articles ou catégories ;
- état vide explicite ;
- pagination ou limite raisonnable pour éviter une liste infinie.

La première version utilise SQL/Eloquent. Aucun moteur externe comme Elasticsearch/Meilisearch n’est requis tant que le catalogue reste de petite taille.

## 10. Favoris

### Visiteur non connecté

- stockage dans `localStorage` ;
- pas de doublons ;
- ajout/suppression sans rechargement complet ;
- page `/favoris` lisant les identifiants et récupérant les articles correspondants.

### Évolution future

Lorsqu’une authentification est ajoutée :

- les favoris sont persistés en base ;
- une synchronisation fusionne proprement les favoris locaux et serveur ;
- les conflits sont résolus sans doublons.

## 11. Quiz japonais

Le quiz actuel est migré vers Livewire.

Fonctions :

- questions lues depuis `quiz_questions` ;
- réponses présentées dynamiquement ;
- score courant ;
- correction immédiate ;
- explication pédagogique ;
- bouton recommencer ;
- fonctionnement au clavier ;
- aucune réponse correcte exposée dans un attribut HTML évitable avant validation.

## 12. Design et expérience utilisateur

L’identité visuelle de la V1 est conservée :

- fond sombre bleu-noir ;
- rouge japonais comme accent principal ;
- rose sakura utilisé avec retenue ;
- surfaces contrastées ;
- illustrations inspirées du Japon ;
- interface moderne, lisible et chaleureuse.

### Responsive

Le site doit être utilisable sur :

- smartphone ;
- tablette ;
- ordinateur portable ;
- écran large.

Le header se transforme en navigation mobile accessible. Les grilles s’adaptent automatiquement via Tailwind.

### Accessibilité

- navigation clavier ;
- focus visible ;
- contraste suffisant ;
- labels de formulaires ;
- `aria-expanded` sur la navigation mobile ;
- textes alternatifs pertinents ;
- respect de `prefers-reduced-motion` ;
- structure sémantique avec landmarks et titres hiérarchisés.

## 13. SEO et métadonnées

Chaque page fournit :

- `<title>` spécifique ;
- meta description ;
- URL canonique lorsque le domaine sera défini ;
- Open Graph de base ;
- sitemap générable depuis les routes et contenus publiés ;
- `robots.txt` adapté à l’environnement ;
- données structurées Schema.org uniquement lorsque pertinentes et exactes.

Les pages de résultats de recherche internes ne doivent pas nécessairement être indexées.

## 14. Sécurité

La V2 utilise les protections natives de Laravel :

- CSRF sur les requêtes mutantes ;
- validation serveur ;
- échappement Blade par défaut ;
- requêtes Eloquent paramétrées ;
- aucune clé secrète stockée dans le dépôt ;
- `.env` hors Git ;
- logs sans données sensibles inutiles ;
- cookies sécurisés selon l’environnement de production.

Si une administration ou une authentification est ajoutée plus tard, elle devra avoir sa propre spécification de sécurité et d’autorisation.

## 15. Performances

Objectifs :

- rendu serveur rapide ;
- chargement différé des images non critiques ;
- assets versionnés et minifiés par Vite ;
- cache des données stables en production lorsque utile ;
- éviter les composants Livewire sur les sections qui n’ont pas besoin d’interactivité ;
- aucune dépendance lourde sans bénéfice concret.

## 16. Environnements et déploiement

### Développement local

Prérequis :

- PHP 8.5 ;
- Composer ;
- Node.js LTS ;
- npm ;
- SQLite.

Commandes attendues après installation :

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

### Production

Cible compatible :

- hébergement PHP supportant PHP 8.5 ;
- Nginx ou Apache ;
- SQLite pour petit déploiement ou MySQL/MariaDB pour hébergement classique ;
- HTTPS obligatoire ;
- `APP_DEBUG=false` ;
- commandes de cache Laravel adaptées au déploiement.

## 17. Tests d’acceptation

La migration est considérée réussie lorsque :

1. toutes les routes publiques principales répondent en HTTP 200 ;
2. les 40 contenus V1 sont présents après `migrate:fresh --seed` ;
3. chaque ancien grand thème possède sa page Laravel ;
4. la recherche trouve les contenus par titre, résumé et mot-clé ;
5. les favoris locaux fonctionnent sans doublons ;
6. le quiz japonais calcule correctement le score et la correction ;
7. les pages légales sont accessibles ;
8. les tests Pest sont verts ;
9. `npm run build` réussit ;
10. Laravel Pint ne signale pas de problème sur les fichiers PHP du projet ;
11. aucune ancienne URL majeure n’aboutit à une 404 lorsque la redirection est configurée ;
12. l’interface reste fonctionnelle sur mobile et desktop.

## 18. Hors périmètre de cette première refonte

Ces fonctionnalités sont préparées mais non incluses dans la première implémentation, afin de garder une migration maîtrisée :

- inscription et connexion utilisateurs complètes ;
- panneau d’administration CMS ;
- commentaires ;
- notifications ;
- newsletter ;
- API publique ;
- moteur de recherche externe ;
- paiement ;
- application mobile native.

Chacune pourra être ajoutée ensuite comme sous-projet indépendant sans restructurer toute la base.

## 19. Stratégie de migration

La migration se fait en étapes afin de garder un site testable à chaque point :

1. créer le squelette Laravel moderne ;
2. configurer Tailwind/Vite et le layout global ;
3. créer migrations, modèles et seeders ;
4. importer les 40 contenus existants ;
5. migrer les catégories et pages éditoriales ;
6. remplacer la recherche JavaScript par Livewire ;
7. migrer le quiz ;
8. intégrer les favoris avec couche de compatibilité locale ;
9. ajouter SEO, redirections, pages légales ;
10. vérifier tests, build et documentation d’installation.

## 20. Décisions retenues

- Laravel 13 plutôt que PHP procédural : meilleure structure et évolutivité.
- Livewire 4 plutôt qu’une SPA React/Vue : interactivité moderne tout en restant centré PHP.
- Tailwind 4.3 plutôt que conserver quatre gros fichiers CSS séparés : design system plus cohérent et maintenance facilitée.
- SQLite en développement : installation immédiate ; MySQL/MariaDB restent supportés en production.
- Blade + Livewire plutôt que tout rendre dynamique : simplicité et performances.
- Import des données existantes plutôt que réécriture manuelle : continuité du contenu et réduction du risque de perte.

## 21. Références techniques au 27 août 2026

- PHP : https://www.php.net/
- Versions PHP supportées : https://www.php.net/supported-versions.php
- Laravel 13 changelog : https://laravel.com/framework/docs/changelog
- Livewire 4 : https://livewire.laravel.com/docs/4.x/
- Tailwind CSS 4.3 : https://tailwindcss.com/blog/tailwindcss-v4-3
