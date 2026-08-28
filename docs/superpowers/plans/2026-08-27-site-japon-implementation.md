# Site Japon Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Construire un portail web statique complet en français consacré au Japon, responsive, accessible, rapide et déployable sans backend.

**Architecture:** Site HTML5 multi-pages avec CSS partagé et JavaScript vanilla en modules ES. Les contenus structurés vivent dans `assets/data/content.js` afin d'alimenter la recherche, les favoris et certaines cartes, sans appel réseau requis. Les fonctionnalités sont décomposées en petits modules testables avec le test runner natif de Node.js.

**Tech Stack:** HTML5, CSS3, JavaScript ES modules, Web Storage API, Node.js `node:test`, Python `http.server` pour les tests de navigation locaux.

**Spec:** `docs/superpowers/specs/2026-08-27-site-japon-design.md`

## Global Constraints

- Le site est entièrement en français.
- La V1 fonctionne sans backend, base de données, authentification ni framework JavaScript.
- Aucun appel réseau n'est requis pour le fonctionnement de base du site.
- Le contenu principal et la navigation restent accessibles lorsque JavaScript est désactivé.
- Le site doit fonctionner sur smartphone, tablette, ordinateur portable et grand écran.
- Le menu mobile doit être accessible au clavier et aux lecteurs d'écran.
- Le site doit prendre en charge `prefers-reduced-motion`.
- Toutes les images de contenu ont un texte alternatif, des dimensions déclarées et `loading="lazy"` hors contenu critique.
- Chaque page possède un titre, une meta description et des balises Open Graph de base.
- La recherche ignore la casse et interroge titre, résumé et mots-clés.
- Les favoris sont stockés dans `localStorage`, sans doublons, et peuvent être supprimés.
- Les défaillances de données ou fonctionnalités JS doivent produire un état non bloquant.

---

## File map

- `index.html` — accueil et accès aux grandes rubriques.
- `manga-anime.html` — manga, anime, démographies, genres, glossaire.
- `culture.html` — traditions, spiritualités, arts, étiquette, pop culture.
- `voyage.html` — destinations, transports, hébergement, conseils.
- `cuisine.html` — plats, desserts, boissons et usages.
- `histoire.html` — frise chronologique pédagogique.
- `technologie.html` — innovation, transport, jeux vidéo, automobile.
- `japonais.html` — écritures, expressions et mini quiz.
- `favoris.html` — liste des éléments enregistrés.
- `recherche.html` — résultats de recherche interne.
- `mentions-legales.html` — informations légales génériques à personnaliser avant publication commerciale.
- `confidentialite.html` — politique de confidentialité adaptée à une V1 sans compte ni traqueur.
- `assets/css/base.css` — variables, reset, typographie, accessibilité, utilitaires.
- `assets/css/components.css` — header, footer, cartes, boutons, formulaires, badges.
- `assets/css/pages.css` — hero, sections et mises en page spécifiques.
- `assets/css/responsive.css` — breakpoints et adaptation mobile/tablette.
- `assets/js/content.js` — catalogue statique partagé, exports `CONTENT_ITEMS` et `getContentById`.
- `assets/js/search.js` — normalisation et recherche pure.
- `assets/js/favorites.js` — lecture/écriture/ajout/suppression des favoris.
- `assets/js/quiz.js` — moteur de quiz pur.
- `assets/js/ui.js` — menu mobile, scroll reveal, boutons favoris et comportements DOM.
- `assets/js/search-page.js` — contrôleur DOM de la page recherche.
- `assets/js/favorites-page.js` — contrôleur DOM de la page favoris.
- `assets/js/japanese-page.js` — contrôleur DOM du quiz.
- `assets/data/search-index.json` — index de secours/interopérabilité pour la recherche.
- `assets/images/` — illustrations locales générées ou décoratives.
- `tests/search.test.mjs` — tests de recherche.
- `tests/favorites.test.mjs` — tests favoris avec faux storage.
- `tests/quiz.test.mjs` — tests du quiz.
- `tests/site-structure.test.mjs` — contrôle des pages, métadonnées et liens essentiels.
- `package.json` — scripts de test.
- `robots.txt`, `sitemap.xml`, `site.webmanifest`, `favicon.svg` — SEO et intégration navigateur.

---

### Task 1: Foundation, metadata and shared shell

**Files:**
- Create: `package.json`
- Create: `assets/css/base.css`
- Create: `assets/css/components.css`
- Create: `assets/css/pages.css`
- Create: `assets/css/responsive.css`
- Create: `tests/site-structure.test.mjs`
- Create: `favicon.svg`
- Create: `site.webmanifest`

**Interfaces:**
- Produces: classes CSS communes (`.site-header`, `.site-nav`, `.card`, `.button`, `.section`, `.container`) utilisées par toutes les pages.
- Produces: script `npm test` exécutant `node --test tests/*.test.mjs`.

- [ ] **Step 1: Write the failing structure test**

```js
// tests/site-structure.test.mjs
import test from 'node:test';
import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';

const pages = ['index.html','manga-anime.html','culture.html','voyage.html','cuisine.html','histoire.html','technologie.html','japonais.html','favoris.html','recherche.html','mentions-legales.html','confidentialite.html'];

test('every page has French language, title, description and main landmark', async () => {
  for (const page of pages) {
    const html = await readFile(new URL(`../${page}`, import.meta.url), 'utf8');
    assert.match(html, /<html[^>]+lang="fr"/i, page);
    assert.match(html, /<title>[^<]+<\/title>/i, page);
    assert.match(html, /<meta\s+name="description"\s+content="[^"]+"/i, page);
    assert.match(html, /<main[\s>]/i, page);
  }
});
```

- [ ] **Step 2: Run the test and verify it fails**

Run: `node --test tests/site-structure.test.mjs`
Expected: FAIL because pages do not exist yet.

- [ ] **Step 3: Create package metadata and shared CSS foundation**

Create `package.json` with:

```json
{
  "name": "japon-explorer",
  "private": true,
  "type": "module",
  "scripts": { "test": "node --test tests/*.test.mjs" }
}
```

Implement shared typography, palette, focus states, containers, buttons, cards, skip-link and reduced-motion rules in the four CSS files.

- [ ] **Step 4: Create favicon and web manifest**

Use an original minimalist red-sun SVG and a manifest with `name: "Japon Explorer"`, `lang: "fr"`, `display: "standalone"`.

- [ ] **Step 5: Commit**

```bash
git add package.json assets/css tests/site-structure.test.mjs favicon.svg site.webmanifest
git commit -m "chore: add site foundation and test harness"
```

---

### Task 2: Static content catalogue

**Files:**
- Create: `assets/js/content.js`
- Create: `assets/data/search-index.json`

**Interfaces:**
- Produces: `CONTENT_ITEMS: Array<{id:string,title:string,category:string,summary:string,keywords:string[],url:string}>`.
- Produces: `getContentById(id:string): object|undefined`.

- [ ] **Step 1: Write a catalogue integrity test**

Add to `tests/site-structure.test.mjs`:

```js
import { CONTENT_ITEMS, getContentById } from '../assets/js/content.js';

test('content catalogue has unique ids and resolvable URLs', () => {
  const ids = CONTENT_ITEMS.map(item => item.id);
  assert.equal(new Set(ids).size, ids.length);
  assert.ok(CONTENT_ITEMS.length >= 30);
  for (const item of CONTENT_ITEMS) {
    assert.ok(item.title && item.summary && item.url);
    assert.equal(getContentById(item.id)?.id, item.id);
  }
});
```

- [ ] **Step 2: Run and verify failure**

Run: `npm test`
Expected: FAIL because `assets/js/content.js` does not exist.

- [ ] **Step 3: Implement the catalogue**

Populate at least 30 editorial entries spanning all eight themes and export `getContentById` using `Array.prototype.find`.

- [ ] **Step 4: Mirror searchable fields into JSON**

Create `assets/data/search-index.json` with the same `id`, `title`, `category`, `summary`, `keywords`, `url` values.

- [ ] **Step 5: Run tests**

Run: `npm test`
Expected: catalogue test PASS; page structure test may still fail until pages are created.

- [ ] **Step 6: Commit**

```bash
git add assets/js/content.js assets/data/search-index.json tests/site-structure.test.mjs
git commit -m "feat: add Japan editorial content catalogue"
```

---

### Task 3: Search engine

**Files:**
- Create: `assets/js/search.js`
- Create: `tests/search.test.mjs`

**Interfaces:**
- Produces: `normalizeText(value:string): string`.
- Produces: `searchItems(items:Array, query:string): Array`.

- [ ] **Step 1: Write failing search tests**

```js
import test from 'node:test';
import assert from 'node:assert/strict';
import { normalizeText, searchItems } from '../assets/js/search.js';

const items = [
  { title:'Kyoto et ses temples', summary:'Sanctuaires et traditions', keywords:['culture','temple'] },
  { title:'Ramen', summary:'Nouilles japonaises', keywords:['cuisine','ramen'] }
];

test('normalizeText ignores case and accents', () => {
  assert.equal(normalizeText('ÉDŌ'), 'edo');
});

test('searchItems searches title summary and keywords', () => {
  assert.equal(searchItems(items, 'TEMPLES').length, 1);
  assert.equal(searchItems(items, 'japonaises')[0].title, 'Ramen');
  assert.equal(searchItems(items, 'cuisine')[0].title, 'Ramen');
});

test('empty query returns an empty result list', () => {
  assert.deepEqual(searchItems(items, '   '), []);
});
```

- [ ] **Step 2: Run and verify failure**

Run: `node --test tests/search.test.mjs`
Expected: FAIL because module does not exist.

- [ ] **Step 3: Implement search**

Implement Unicode normalization with `NFD`, removal of combining marks, lowercase conversion, tokenization by whitespace and an AND match across the combined searchable text.

- [ ] **Step 4: Run tests**

Run: `node --test tests/search.test.mjs`
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add assets/js/search.js tests/search.test.mjs
git commit -m "feat: add client-side search engine"
```

---

### Task 4: Favorites engine

**Files:**
- Create: `assets/js/favorites.js`
- Create: `tests/favorites.test.mjs`

**Interfaces:**
- Produces: `readFavorites(storage): string[]`.
- Produces: `isFavorite(storage,id): boolean`.
- Produces: `addFavorite(storage,id): string[]`.
- Produces: `removeFavorite(storage,id): string[]`.
- Uses storage contract: object implementing `getItem(key)` and `setItem(key,value)`.

- [ ] **Step 1: Write failing favorites tests**

```js
import test from 'node:test';
import assert from 'node:assert/strict';
import { readFavorites, addFavorite, removeFavorite, isFavorite } from '../assets/js/favorites.js';

function fakeStorage() {
  const map = new Map();
  return { getItem:k => map.get(k) ?? null, setItem:(k,v) => map.set(k,String(v)) };
}

test('favorites add once, detect and remove', () => {
  const storage = fakeStorage();
  addFavorite(storage, 'tokyo');
  addFavorite(storage, 'tokyo');
  assert.deepEqual(readFavorites(storage), ['tokyo']);
  assert.equal(isFavorite(storage, 'tokyo'), true);
  removeFavorite(storage, 'tokyo');
  assert.deepEqual(readFavorites(storage), []);
});

test('corrupt storage fails safely', () => {
  const storage = { getItem:() => '{broken', setItem:() => {} };
  assert.deepEqual(readFavorites(storage), []);
});
```

- [ ] **Step 2: Run and verify failure**

Run: `node --test tests/favorites.test.mjs`
Expected: FAIL because module does not exist.

- [ ] **Step 3: Implement favorites**

Use one constant storage key (`japon-explorer:favorites`), JSON serialization, `Set` for duplicate prevention, and defensive parsing.

- [ ] **Step 4: Run tests and commit**

Run: `node --test tests/favorites.test.mjs`
Expected: PASS.

```bash
git add assets/js/favorites.js tests/favorites.test.mjs
git commit -m "feat: add local favorites engine"
```

---

### Task 5: Japanese mini quiz engine

**Files:**
- Create: `assets/js/quiz.js`
- Create: `tests/quiz.test.mjs`

**Interfaces:**
- Produces: `QUIZ_QUESTIONS: Array<{prompt:string,choices:string[],answer:number,explanation:string}>`.
- Produces: `checkAnswer(question, choiceIndex): {correct:boolean, explanation:string}`.

- [ ] **Step 1: Write failing quiz tests**

```js
import test from 'node:test';
import assert from 'node:assert/strict';
import { QUIZ_QUESTIONS, checkAnswer } from '../assets/js/quiz.js';

test('quiz exposes multiple valid questions', () => {
  assert.ok(QUIZ_QUESTIONS.length >= 6);
  for (const q of QUIZ_QUESTIONS) assert.ok(q.choices[q.answer]);
});

test('checkAnswer reports correctness and explanation', () => {
  const q = { answer:1, explanation:'Réponse test' };
  assert.deepEqual(checkAnswer(q,1), { correct:true, explanation:'Réponse test' });
  assert.equal(checkAnswer(q,0).correct, false);
});
```

- [ ] **Step 2: Run and verify failure**

Run: `node --test tests/quiz.test.mjs`
Expected: FAIL.

- [ ] **Step 3: Implement the quiz engine**

Add at least six beginner questions covering hiragana, katakana, greetings and pronunciation.

- [ ] **Step 4: Run tests and commit**

Run: `node --test tests/quiz.test.mjs`
Expected: PASS.

```bash
git add assets/js/quiz.js tests/quiz.test.mjs
git commit -m "feat: add beginner Japanese quiz engine"
```

---

### Task 6: Shared navigation and UI behaviors

**Files:**
- Create: `assets/js/ui.js`
- Modify: `assets/css/components.css`
- Modify: `assets/css/responsive.css`

**Interfaces:**
- Consumes: favorites functions from `favorites.js`.
- Produces DOM behavior for `[data-menu-toggle]`, `[data-site-nav]`, `[data-favorite-id]`, `[data-reveal]`.

- [ ] **Step 1: Add markup contract assertions**

Extend `tests/site-structure.test.mjs` so every public content page must include `.site-header`, `.site-footer`, a skip link, and a link to `recherche.html`.

- [ ] **Step 2: Run and verify failure**

Run: `npm test`
Expected: FAIL until page shells exist.

- [ ] **Step 3: Implement `ui.js`**

Implement menu toggle with `aria-expanded`, Escape-to-close, favorite button sync with `aria-pressed`, and IntersectionObserver reveal that is skipped when reduced motion is requested.

- [ ] **Step 4: Complete menu/favorite states in CSS**

Ensure visible keyboard focus, touch-friendly controls, mobile drawer behavior and no-motion fallback.

- [ ] **Step 5: Commit**

```bash
git add assets/js/ui.js assets/css/components.css assets/css/responsive.css tests/site-structure.test.mjs
git commit -m "feat: add accessible shared UI behaviors"
```

---

### Task 7: Build home and eight thematic pages

**Files:**
- Create: `index.html`
- Create: `manga-anime.html`
- Create: `culture.html`
- Create: `voyage.html`
- Create: `cuisine.html`
- Create: `histoire.html`
- Create: `technologie.html`
- Create: `japonais.html`
- Modify: `assets/css/pages.css`
- Modify: `assets/css/responsive.css`

**Interfaces:**
- Consumes: CSS classes from Tasks 1 and 6.
- Consumes: `assets/js/ui.js` on every page.
- `japonais.html` reserves `#quiz-root` for Task 9.

- [ ] **Step 1: Expand structure test for common assets**

Assert each page includes `favicon.svg`, shared CSS files, `assets/js/ui.js` with `type="module"`, and canonical navigation links.

- [ ] **Step 2: Run and verify failure**

Run: `npm test`
Expected: FAIL because pages are missing.

- [ ] **Step 3: Implement `index.html`**

Include hero, eight-theme explorer, manga/anime selection, five destinations, fact panel, cuisine selection, Japanese starter, technology block and favorites callout.

- [ ] **Step 4: Implement thematic pages**

Each page uses semantic sections, editorial cards and anchor ids corresponding to URLs in `CONTENT_ITEMS`. `histoire.html` includes a chronological timeline. `japonais.html` includes hiragana/katakana starter tables with captions.

- [ ] **Step 5: Run structure tests**

Run: `npm test`
Expected: all existing logic tests PASS; structure tests for remaining utility/legal pages may still fail.

- [ ] **Step 6: Commit**

```bash
git add index.html manga-anime.html culture.html voyage.html cuisine.html histoire.html technologie.html japonais.html assets/css/pages.css assets/css/responsive.css tests/site-structure.test.mjs
git commit -m "feat: build Japan home and thematic pages"
```

---

### Task 8: Search page

**Files:**
- Create: `recherche.html`
- Create: `assets/js/search-page.js`

**Interfaces:**
- Consumes: `CONTENT_ITEMS` and `searchItems`.
- Reads query parameter `q`.
- Renders into `#search-results` and updates `#search-status`.

- [ ] **Step 1: Add structure assertions**

Assert `recherche.html` contains `<form role="search">`, an input named `q`, `#search-results`, and `assets/js/search-page.js`.

- [ ] **Step 2: Run and verify failure**

Run: `npm test`
Expected: FAIL for missing search page.

- [ ] **Step 3: Implement search page controller**

Parse `URLSearchParams`, run `searchItems`, HTML-escape by assigning text via DOM nodes, render category badge/title/summary/link, and show helpful zero-result state.

- [ ] **Step 4: Run tests and commit**

Run: `npm test`
Expected: search logic tests PASS and page structure search assertions PASS.

```bash
git add recherche.html assets/js/search-page.js tests/site-structure.test.mjs
git commit -m "feat: add interactive search page"
```

---

### Task 9: Favorites page and Japanese quiz UI

**Files:**
- Create: `favoris.html`
- Create: `assets/js/favorites-page.js`
- Create: `assets/js/japanese-page.js`
- Modify: `japonais.html`

**Interfaces:**
- Favorites page consumes `readFavorites`, `removeFavorite`, `getContentById`.
- Japanese page consumes `QUIZ_QUESTIONS`, `checkAnswer`.

- [ ] **Step 1: Add required DOM assertions**

Assert `favoris.html` has `#favorites-list` and `#favorites-empty`; assert `japonais.html` has `#quiz-root` and its controller script.

- [ ] **Step 2: Run and verify failure**

Run: `npm test`
Expected: FAIL for missing favorites page/controller.

- [ ] **Step 3: Implement favorites page**

Render saved content cards, support remove buttons, immediately update count/empty state, and show a non-blocking message if storage access throws.

- [ ] **Step 4: Implement quiz controller**

Render one question at a time, choices as buttons, feedback with explanation, next-question progression and final score. Keep all questions available in HTML-adjacent explanatory content so no core learning text depends on JS.

- [ ] **Step 5: Run tests and commit**

Run: `npm test`
Expected: PASS except any still-missing legal/SEO files.

```bash
git add favoris.html japonais.html assets/js/favorites-page.js assets/js/japanese-page.js tests/site-structure.test.mjs
git commit -m "feat: add favorites page and Japanese quiz UI"
```

---

### Task 10: Legal pages, SEO and crawlability

**Files:**
- Create: `mentions-legales.html`
- Create: `confidentialite.html`
- Create: `robots.txt`
- Create: `sitemap.xml`
- Modify: all HTML pages as needed for Open Graph and footer links.

**Interfaces:**
- Produces crawlable static documents and legal navigation.

- [ ] **Step 1: Extend SEO assertions**

Add checks that every page has `og:title`, `og:description`, favicon reference and footer links to both legal pages. Assert `robots.txt` references `sitemap.xml` and sitemap lists all public HTML pages.

- [ ] **Step 2: Run and verify failure**

Run: `npm test`
Expected: FAIL for missing legal/SEO artifacts.

- [ ] **Step 3: Implement legal pages**

State clearly that the template owner/editor/host identity must be completed before public/commercial deployment. Privacy page states no account, no advertising tracker, and local-only favorites in V1.

- [ ] **Step 4: Implement sitemap and robots**

Use relative-safe documented placeholder origin `https://example.com/` with an explicit comment in README-equivalent deployment notes inside `mentions-legales.html` telling the owner to replace it before production.

- [ ] **Step 5: Run tests and commit**

Run: `npm test`
Expected: PASS.

```bash
git add mentions-legales.html confidentialite.html robots.txt sitemap.xml *.html tests/site-structure.test.mjs
git commit -m "feat: add legal pages and SEO metadata"
```

---

### Task 11: Local visuals and performance polish

**Files:**
- Create: `assets/images/hero-japan.svg`
- Create: `assets/images/sakura-pattern.svg`
- Create: `assets/images/tokyo.svg`
- Create: `assets/images/kyoto.svg`
- Create: `assets/images/cuisine.svg`
- Modify: relevant HTML pages
- Modify: `assets/css/pages.css`

**Interfaces:**
- Pure local assets; no remote image dependency.

- [ ] **Step 1: Add image hygiene assertions**

Check content `<img>` tags for `alt`, numeric `width`, numeric `height`; require `loading="lazy"` except hero image.

- [ ] **Step 2: Run and verify failure**

Run: `npm test`
Expected: FAIL until image attributes/assets are complete.

- [ ] **Step 3: Add original local SVG illustrations**

Create stylized, copyright-safe illustrations using geometric silhouettes: red sun/mountain/wave hero, sakura texture, Tokyo skyline, Kyoto torii/roofline and cuisine bowl/chopsticks.

- [ ] **Step 4: Wire image dimensions and lazy loading**

Use SVG intrinsic viewBox plus explicit HTML dimensions. Keep the hero eager; other content images lazy.

- [ ] **Step 5: Run tests and commit**

Run: `npm test`
Expected: PASS.

```bash
git add assets/images assets/css/pages.css *.html tests/site-structure.test.mjs
git commit -m "feat: add original local Japan illustrations"
```

---

### Task 12: Final verification and distributable package

**Files:**
- Create: `README.md`
- Create: `dist/site-japon.zip`

**Interfaces:**
- README documents local launch and deployment.
- ZIP contains runtime files but excludes `.git`, `tests`, `docs`, and `dist` itself.

- [ ] **Step 1: Run full automated suite**

Run: `npm test`
Expected: all tests PASS with zero failures.

- [ ] **Step 2: Serve site locally**

Run in project root: `python3 -m http.server 8080`

Verify with:

```bash
curl -I http://127.0.0.1:8080/
curl -I http://127.0.0.1:8080/recherche.html?q=tokyo
curl -I http://127.0.0.1:8080/japonais.html
```

Expected: `HTTP/1.0 200 OK` or `HTTP/1.1 200 OK` for each page.

- [ ] **Step 3: Check internal local references**

Use a small Node test in `tests/site-structure.test.mjs` to parse `href`/`src` values beginning with local paths and confirm every referenced file exists.

Run: `npm test`
Expected: PASS.

- [ ] **Step 4: Write README**

Document: double-click limitation for module scripts, recommended `python3 -m http.server 8080`, how to change colors/content, how favorites work, how to replace `example.com` in SEO files, and deployment examples for GitHub Pages/Netlify/static hosting.

- [ ] **Step 5: Create distribution ZIP**

```bash
mkdir -p dist
zip -r dist/site-japon.zip index.html manga-anime.html culture.html voyage.html cuisine.html histoire.html technologie.html japonais.html favoris.html recherche.html mentions-legales.html confidentialite.html assets robots.txt sitemap.xml site.webmanifest favicon.svg README.md
```

- [ ] **Step 6: Inspect archive**

Run: `unzip -l dist/site-japon.zip`
Expected: all runtime pages/assets present; no `.git`, `tests`, `docs`, or nested `dist`.

- [ ] **Step 7: Commit final verification assets**

```bash
git add README.md tests/site-structure.test.mjs
git commit -m "docs: add deployment guide and final verification"
```
