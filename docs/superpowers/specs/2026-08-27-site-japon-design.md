# Site Japon — Spécification de conception

Date : 2026-08-27

## 1. Objectif

Créer un site web complet en français consacré au Japon, visuellement moderne, rapide, responsive et simple à déployer sur un hébergement statique. La première version doit fonctionner sans backend ni base de données.

Le site doit servir de portail grand public autour de huit grands thèmes : découverte du Japon, manga et anime, culture et traditions, voyage, cuisine, histoire, technologie et apprentissage du japonais.

## 2. Public visé

- Francophones intéressés par le Japon.
- Fans de manga et d’anime.
- Voyageurs préparant un séjour au Japon.
- Débutants souhaitant découvrir la langue et la culture japonaise.
- Curieux intéressés par la technologie et l’histoire du pays.

## 3. Architecture générale

La V1 sera un site statique multi-pages basé sur :

- HTML5 sémantique.
- CSS3 moderne avec variables CSS, grille et flexbox.
- JavaScript vanilla modulaire.
- LocalStorage pour les favoris et certaines préférences utilisateur.
- Aucune dépendance obligatoire à un framework JavaScript.
- Aucune base de données ni authentification en V1.

Arborescence cible :

- `index.html` — accueil.
- `manga-anime.html` — mangas et anime.
- `culture.html` — culture et traditions.
- `voyage.html` — destinations et conseils de voyage.
- `cuisine.html` — cuisine japonaise.
- `histoire.html` — histoire du Japon.
- `technologie.html` — innovation et Japon moderne.
- `japonais.html` — initiation au japonais.
- `favoris.html` — contenus enregistrés localement.
- `recherche.html` — résultats de recherche interne.
- `mentions-legales.html` — mentions légales.
- `confidentialite.html` — politique de confidentialité.
- `assets/css/` — styles.
- `assets/js/` — scripts.
- `assets/images/` — images et illustrations locales.
- `assets/data/` — données JSON statiques utilisées par la recherche et les cartes de contenu.

## 4. Navigation

Le site comporte un en-tête commun avec :

- Logo / nom du site.
- Accueil.
- Manga & Anime.
- Culture.
- Voyage.
- Cuisine.
- Histoire.
- Technologie.
- Japonais.
- Recherche.
- Favoris.

Sur mobile, le menu devient un menu hamburger accessible au clavier et aux lecteurs d’écran.

Le pied de page contient les liens utiles, les mentions légales, la confidentialité et un rappel des principales rubriques.

## 5. Direction artistique

### Palette

- Fond principal sombre, proche du noir bleuté.
- Rouge japonais comme couleur d’accent principale.
- Blanc cassé pour les textes.
- Rose sakura utilisé avec parcimonie pour les détails décoratifs.
- Gris neutres pour les surfaces secondaires.

### Style

- Atmosphère moderne inspirée du Japon contemporain.
- Mélange visuel entre tradition et modernité.
- Cartes éditoriales avec images, catégories et résumés.
- Grandes zones respirantes et typographie très lisible.
- Animations discrètes uniquement : apparition au scroll, transitions de cartes, interactions du menu.
- Aucun effet lourd qui nuirait aux performances.

## 6. Page d’accueil

La page d’accueil comprend :

1. Hero immersif avec un grand titre sur le Japon et un appel à explorer les rubriques.
2. Section « Explorer le Japon » avec accès rapide aux huit thèmes.
3. Sélection Manga & Anime.
4. Destinations phares : Tokyo, Kyoto, Osaka, Hokkaido et Okinawa.
5. Encadré « Le saviez-vous ? » avec faits culturels courts.
6. Sélection cuisine japonaise.
7. Bloc initiation au japonais.
8. Bloc technologie et Japon moderne.
9. Appel à enregistrer des contenus dans les favoris.

## 7. Pages thématiques

### Manga & Anime

- Présentation du média manga et de l’animation japonaise.
- Grandes catégories : shonen, shojo, seinen, josei, kodomo.
- Genres populaires.
- Sélection de séries emblématiques sous forme de cartes éditoriales.
- Glossaire de termes utiles.

### Culture & traditions

- Religions et spiritualités.
- Temples et sanctuaires.
- Matsuri.
- Onsen et règles de savoir-vivre.
- Arts traditionnels.
- Étiquette et vie quotidienne.
- Culture pop contemporaine.

### Voyage

- Tokyo.
- Kyoto.
- Osaka.
- Hokkaido.
- Okinawa.
- Transports.
- Hébergement.
- Conseils pratiques.
- Bonnes manières pour les visiteurs.

La V1 reste informative et ne fournit pas de prix ou horaires temps réel.

### Cuisine

- Sushi et sashimi.
- Ramen.
- Udon et soba.
- Donburi.
- Curry japonais.
- Okonomiyaki.
- Yakitori.
- Wagashi et desserts.
- Boissons traditionnelles et modernes présentées de manière informative.

### Histoire

- Japon ancien.
- Époque des samouraïs.
- Période Edo.
- Restauration Meiji.
- Japon du XXe siècle.
- Japon contemporain.

Le contenu doit rester synthétique, pédagogique et chronologique.

### Technologie

- Électronique grand public.
- Robotique.
- Transport ferroviaire.
- Jeux vidéo.
- Automobile.
- Culture numérique.
- Villes intelligentes et innovation.

### Japonais

- Présentation des trois systèmes d’écriture.
- Tableau d’initiation hiragana.
- Tableau d’initiation katakana.
- Premiers mots et expressions.
- Prononciation simple.
- Conseils d’apprentissage.
- Mini quiz JavaScript sans compte utilisateur.

## 8. Recherche interne

La recherche fonctionne entièrement côté client.

Un fichier JSON indexe :

- titre ;
- catégorie ;
- résumé ;
- mots-clés ;
- URL de destination.

Le champ de recherche doit :

- ignorer la casse ;
- rechercher dans les titres, résumés et mots-clés ;
- afficher des résultats regroupés de manière lisible ;
- afficher un état vide clair lorsqu’aucun résultat n’est trouvé.

## 9. Favoris

Chaque carte compatible comporte un bouton « Ajouter aux favoris ».

Les identifiants des contenus sont stockés dans `localStorage`.

La page Favoris reconstruit la liste à partir des données statiques du site.

Le système doit gérer proprement :

- l’ajout ;
- la suppression ;
- l’absence de favoris ;
- les doublons.

## 10. Responsive et accessibilité

Le site doit être utilisable sur :

- smartphone ;
- tablette ;
- ordinateur portable ;
- écran de bureau large.

Objectifs d’accessibilité :

- structure HTML sémantique ;
- contraste suffisant ;
- textes alternatifs sur les images ;
- navigation clavier ;
- focus visible ;
- boutons avec libellés explicites ;
- menu mobile accessible ;
- support de `prefers-reduced-motion`.

## 11. Performance

- JavaScript chargé avec `defer` ou modules adaptés.
- Images compressées et dimensions déclarées.
- Pas de framework lourd.
- CSS partagé entre les pages.
- Lazy loading des images non critiques.
- Aucun appel réseau requis pour le fonctionnement de base du site.

## 12. SEO de base

Chaque page comprend :

- un titre unique ;
- une meta description ;
- une hiérarchie de titres correcte ;
- des URLs lisibles ;
- des données Open Graph de base ;
- un `sitemap.xml` ;
- un `robots.txt` ;
- un favicon.

## 13. Gestion des erreurs et états vides

- Recherche sans résultat : message clair et suggestions de rubriques.
- Favoris vides : explication et lien vers les principales sections.
- Données JSON indisponibles : affichage d’un message non bloquant.
- JavaScript désactivé : navigation et contenu principal restent accessibles, mais recherche/favoris/quiz peuvent être indisponibles.

## 14. Tests de validation

La V1 sera validée par :

- ouverture locale du site sans serveur complexe ;
- vérification de tous les liens internes ;
- test du menu mobile ;
- test de la recherche ;
- test des favoris et de leur persistance ;
- test du quiz japonais ;
- vérification du rendu aux principales largeurs responsive ;
- contrôle qu’aucune erreur JavaScript ne bloque la navigation ;
- vérification des fichiers SEO et légaux.

## 15. Hors périmètre de la V1

Pour garder une première version solide et simple, sont exclus :

- comptes utilisateurs ;
- commentaires ;
- forum ;
- paiement ;
- newsletter connectée à un service externe ;
- système d’administration ;
- base de données ;
- actualités automatisées ;
- prix, horaires ou météo en temps réel.

Ces fonctions pourront être ajoutées dans une V2 sans remettre en cause l’architecture visuelle de la V1.

## 16. Livrable final attendu

Le livrable sera un dossier autonome contenant tous les fichiers du site, plus une archive ZIP prête à télécharger et à déployer.

Le site devra pouvoir être lancé localement et être déployable facilement sur GitHub Pages, Netlify, Cloudflare Pages ou un hébergement web statique classique.
