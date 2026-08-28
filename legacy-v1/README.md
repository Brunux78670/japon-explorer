# Japon Explorer 🇯🇵

Site web statique complet en français consacré au Japon : culture, manga & anime, voyage, cuisine, histoire, technologie et apprentissage du japonais.

## Lancer le site localement

Les scripts JavaScript utilisent les modules ES. Pour éviter les limitations de sécurité de certains navigateurs avec les fichiers ouverts en `file://`, lancez un petit serveur local depuis le dossier du projet :

```bash
python3 -m http.server 8080
```

Puis ouvrez `http://localhost:8080/` dans votre navigateur.

## Fonctionnalités

- 12 pages HTML responsive et accessibles
- 40 entrées éditoriales indexées
- recherche interne sans serveur
- favoris enregistrés uniquement dans `localStorage`
- mini quiz de japonais
- navigation mobile accessible au clavier
- illustrations SVG locales, sans dépendance d’images distante
- SEO de base, Open Graph, sitemap et robots.txt
- prise en charge de `prefers-reduced-motion`

## Modifier les couleurs

Les principales couleurs sont centralisées au début de `assets/css/base.css` dans les variables `:root`, notamment `--red`, `--sakura`, `--bg` et `--text`.

## Modifier le contenu

Les pages contiennent leur texte éditorial directement dans les fichiers HTML pour rester lisibles même sans JavaScript. Le catalogue utilisé par la recherche et les favoris se trouve dans :

- `assets/js/content.js`
- `assets/data/search-index.json`

Si vous ajoutez un sujet searchable, gardez les deux fichiers cohérents et ajoutez une ancre correspondante sur la page concernée.

## Favoris

Les identifiants sont enregistrés sous la clé :

```text
japon-explorer:favorites
```

Aucune donnée n’est envoyée vers un serveur.

## Mise en ligne

Le site peut être hébergé sur n’importe quel hébergement statique : GitHub Pages, Netlify, Cloudflare Pages, OVH, Apache ou Nginx.

Avant publication :

1. Remplacez `https://example.com/` par votre vrai domaine dans `sitemap.xml`.
2. Complétez `mentions-legales.html` avec l’identité de l’éditeur et de l’hébergeur.
3. Mettez à jour `confidentialite.html` si vous ajoutez analytics, formulaires, comptes ou services externes.

## Tests

Avec Node.js installé :

```bash
npm test
```

Les tests vérifient la recherche, les favoris, le quiz, la structure des pages, les métadonnées, les images, le sitemap et les liens locaux.
