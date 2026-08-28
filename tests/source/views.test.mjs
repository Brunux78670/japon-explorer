import test from 'node:test';
import assert from 'node:assert/strict';
import { existsSync, readFileSync } from 'node:fs';

const viewFiles = [
  'resources/views/layouts/app.blade.php',
  'resources/views/components/header.blade.php',
  'resources/views/components/footer.blade.php',
  'resources/views/components/article-card.blade.php',
  'resources/views/components/section-heading.blade.php',
  'resources/views/pages/home.blade.php',
  'resources/views/pages/category.blade.php',
  'resources/views/pages/article.blade.php',
  'resources/views/pages/japanese.blade.php',
  'resources/views/pages/search.blade.php',
  'resources/views/pages/favorites.blade.php',
  'resources/views/pages/legal.blade.php',
  'resources/views/pages/privacy.blade.php',
];

test('Blade layout and shared pages are complete and accessible', () => {
  for (const file of viewFiles) assert.ok(existsSync(file), `missing ${file}`);
  const layout = readFileSync('resources/views/layouts/app.blade.php','utf8');
  assert.match(layout, /<html[^>]+lang="fr"/);
  assert.match(layout, /skip-link/);
  assert.match(layout, /meta name="description"/);
  assert.match(layout, /@vite/);
  assert.match(layout, /@livewireStyles/);
  assert.match(layout, /@livewireScripts/);
  assert.match(layout, /<main[^>]+id="contenu"/);
  const header = readFileSync('resources/views/components/header.blade.php','utf8');
  assert.match(header, /aria-expanded/);
  assert.match(header, /route\('search'\)/);
  assert.match(header, /route\('favorites'\)/);
});

test('dynamic category and article templates use database objects', () => {
  const category = readFileSync('resources/views/pages/category.blade.php','utf8');
  const article = readFileSync('resources/views/pages/article.blade.php','utf8');
  assert.match(category, /\$category->name/);
  assert.match(category, /@foreach\s*\(\$articles/);
  assert.match(article, /\$article->title/);
  assert.match(article, /\$article->body/);
});

test('Tailwind CSS 4 source contains Japan design tokens and reduced-motion handling', () => {
  const css = readFileSync('resources/css/app.css','utf8');
  assert.match(css, /@import "tailwindcss"/);
  assert.match(css, /--color-japan-red/);
  assert.match(css, /prefers-reduced-motion/);
});
