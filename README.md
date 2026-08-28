# Japon Explorer — Laravel 13

Japon Explorer est un portail francophone moderne consacré au Japon : manga et anime, culture, voyage, cuisine, histoire, technologie et apprentissage du japonais.

Cette V2 migre la V1 statique vers une application Laravel pilotée par base de données, avec Blade, Livewire et Tailwind CSS.

## Stack

- **PHP 8.5 ciblé** ; le projet déclare `PHP ^8.3` pour rester compatible avec PHP 8.3, 8.4 et 8.5.
- **Laravel 13**.
- **Livewire 4** pour la recherche et le quiz.
- **Tailwind CSS 4.3** + **Vite**.
- **SQLite** par défaut ; **MySQL / MariaDB** compatibles en production.
- **Pest 4** et **Laravel Pint** pour la qualité.

## Fonctionnalités

- 40 fiches migrées de Japon Explorer V1 et 7 catégories.
- Pages dynamiques Laravel sans duplication de template.
- Recherche instantanée insensible aux accents et à la casse.
- Favoris visiteurs dans `localStorage`, sans compte et sans doublons.
- Quiz japonais Livewire avec score et correction immédiate.
- Redirections 301 des anciennes URLs `.html`.
- Sitemap XML dynamique, robots, canonical et Open Graph.
- Design responsive sombre, rouge japonais et sakura.
- Navigation clavier, focus visible et prise en compte de `prefers-reduced-motion`.

## Prérequis

Installe :

- PHP 8.3 minimum, PHP 8.5 recommandé ;
- extensions PHP usuelles de Laravel, notamment `mbstring`, `openssl`, `pdo`, `sqlite3`/`pdo_sqlite`, `xml`, `ctype`, `json`, `tokenizer`, `fileinfo` ;
- Composer ;
- Node.js récent et npm ;
- SQLite pour la configuration par défaut.

Sur une distribution Ubuntu récente, les paquets génériques sont généralement disponibles avec :

```bash
sudo apt update
sudo apt install php-cli php-sqlite3 php-mbstring php-xml php-curl php-zip composer nodejs npm
```

## Installation locale

Depuis la racine du projet :

```bash
composer install
npm install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Ouvre ensuite :

```text
http://127.0.0.1:8000
```

Pour travailler sur le CSS/JavaScript avec rechargement Vite :

```bash
npm run dev
```

## Vérifications

Tests Laravel/Pest :

```bash
php artisan test
```

Style PHP :

```bash
vendor/bin/pint --test
```

Build frontend :

```bash
npm run build
```

Validation source autonome, utile avant même `composer install` :

```bash
node scripts/verify-source.mjs
```

## Base de données

### SQLite

La configuration `.env.example` utilise SQLite :

```dotenv
DB_CONNECTION=sqlite
```

Crée le fichier puis initialise la base :

```bash
touch database/database.sqlite
php artisan migrate --seed
```

Le seeding doit créer exactement **7 catégories, 40 articles et 8 questions de quiz**.

### MySQL / MariaDB

Exemple :

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=japon_explorer
DB_USERNAME=japon
DB_PASSWORD=change-moi
```

Puis :

```bash
php artisan migrate --seed
```

## Arborescence utile

```text
app/
  Http/Controllers/ContentController.php
  Livewire/Search/GlobalSearch.php
  Livewire/Japanese/Quiz.php
  Models/
  Services/SearchService.php
  Support/
database/
  data/articles.json
  data/quiz.php
  migrations/
  seeders/
resources/
  css/app.css
  js/app.js
  js/favorites.js
  views/
routes/web.php
legacy-v1/
tests/
```

`legacy-v1/` conserve la version statique complète d'origine comme référence et filet de sécurité.

## Routes principales

```text
/
/manga-anime
/culture
/voyage
/cuisine
/histoire
/technologie
/japonais
/recherche
/favoris
/articles/{slug}
/mentions-legales
/confidentialite
/sitemap.xml
```

## Production

Avant mise en ligne :

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ton-domaine.fr
SESSION_SECURE_COOKIE=true
```

Puis exécute selon ton hébergement :

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Le document `BUILD-STATUS.md` indique quelles vérifications ont réellement été exécutées dans l'environnement de génération du projet.
