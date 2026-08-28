# Build status — Japon Explorer Laravel V2

Date de génération : 27 août 2026.

## Environnement de génération disponible

- PHP CLI : **8.4.23**.
- Node.js : **22.16.0**.
- npm : **10.9.2**.
- Composer : **indisponible dans le conteneur**.
- `node_modules` : absent.
- Accès DNS sortant : indisponible dans le conteneur de génération.

Le projet cible PHP 8.5 en production tout en déclarant `PHP ^8.3` dans `composer.json`, ce qui permet l’installation avec PHP 8.3, 8.4 ou 8.5 lorsque les extensions Laravel requises sont présentes.

## Vérifications exécutées ici

Les vérifications suivantes ont réellement été exécutées sur le code livré :

```bash
node scripts/verify-source.mjs
```

Ce script vérifie :

- tous les tests source Node ;
- la syntaxe des fichiers PHP applicatifs avec `php -l` ;
- la validité de `composer.json`, `package.json` et des données JSON ;
- la présence de **40 articles** dans le jeu de données migré ;
- les contraintes structurelles Laravel/Livewire/Tailwind ;
- la logique pure des favoris, de la normalisation de recherche et du moteur de quiz.

Le ZIP final est également vérifié avec `tests/package-artifact.test.mjs` pour confirmer qu’il contient les fichiers essentiels et exclut `.env`, Git, `vendor` et `node_modules`.

## Vérifications impossibles dans ce conteneur

Les commandes suivantes **n’ont pas pu être exécutées ici**, car Composer n’est pas installé et le conteneur ne peut pas télécharger les dépendances depuis Internet :

```bash
composer install
php artisan migrate:fresh --seed
php artisan test
vendor/bin/pint --test
```

Le build frontend n’a pas non plus pu être exécuté car les paquets npm ne sont pas présents et le cache npm ne contient pas Tailwind/Vite :

```bash
npm install
npm run build
```

La tentative `npm install --offline` a échoué avec `ENOTCACHED` pour `@tailwindcss/vite`, ce qui confirme que les dépendances ne sont pas disponibles localement dans cet environnement.

## Vérification à faire après téléchargement

Sur une machine disposant d’Internet et des extensions PHP nécessaires :

```bash
composer install
npm install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan migrate:fresh --seed
php artisan test
vendor/bin/pint --test
npm run build
php artisan serve
```

Une fois ces commandes vertes, l’application pourra être considérée comme validée de bout en bout dans un vrai runtime Laravel.
