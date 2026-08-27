# Japon Explorer — Laravel v2

Cette branche contient la migration moderne de **Japon Explorer** vers une architecture Laravel.

## Stack cible

- PHP 8.5
- Laravel 13
- Livewire 4
- Tailwind CSS 4
- Vite
- SQLite ou MySQL/MariaDB
- Pest

## Pourquoi le code est en fragments Base64 ?

Le connecteur GitHub utilisé dans cette session accepte les écritures de fichiers texte UTF-8 mais ne peut pas téléverser directement une archive binaire locale. Le cœur source Laravel est donc stocké sans perte dans quatre fragments Base64 :

- `core.part-00.b64`
- `core.part-01.b64`
- `core.part-02.b64`
- `core.part-03.b64`

## Reconstituer le projet

Depuis la racine du dépôt :

```bash
cat packages/core.part-00.b64 \
    packages/core.part-01.b64 \
    packages/core.part-02.b64 \
    packages/core.part-03.b64 \
  | base64 -d > japon-explorer-laravel-core.tar.gz
```

Vérifier l'intégrité :

```bash
sha256sum japon-explorer-laravel-core.tar.gz
```

SHA-256 attendu :

```text
26f14272bfa060909496236cfec279002e248c84162584e44e5db7a6b4335358
```

Extraire :

```bash
mkdir japon-explorer-laravel
tar -xzf japon-explorer-laravel-core.tar.gz -C japon-explorer-laravel
cd japon-explorer-laravel
```

## Installation locale

```bash
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Le site est ensuite accessible par défaut sur `http://127.0.0.1:8000`.

## Contenu de la migration

La source comprend notamment :

- 40 contenus éditoriaux migrés ;
- 7 catégories ;
- recherche Livewire avec normalisation des accents ;
- favoris anonymes avec stockage local ;
- quiz de japonais Livewire ;
- composants Blade réutilisables ;
- thème responsive sombre, rouge et sakura ;
- routes propres et redirections 301 des anciennes URL `.html` ;
- SEO, canonicals, Open Graph, `robots.txt` et sitemap dynamique ;
- migrations et seeders SQLite/MySQL ;
- tests Pest prévus pour les routes, données, recherche et quiz.

## État de validation

Lors de la génération dans ChatGPT :

- 25/25 tests de validation source ont réussi ;
- 1/1 test de l'archive source a réussi ;
- la syntaxe PHP et le jeu de 40 contenus ont été contrôlés.

Le conteneur de génération ne disposait pas de Composer et n'avait pas d'accès réseau sortant, donc `composer install`, les tests Pest exécutés dans Laravel, Pint et le build Vite n'ont pas pu être lancés dans cet environnement. Le fichier `BUILD-STATUS.md` inclus dans l'archive détaille cette limite.
