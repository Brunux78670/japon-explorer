import test from 'node:test';
import assert from 'node:assert/strict';
import { existsSync, readFileSync } from 'node:fs';

const expectedPaths = ['/', '/recherche', '/favoris', '/articles/{article:slug}', '/mentions-legales', '/confidentialite', '/sitemap.xml'];
const categorySlugs = ['manga-anime','culture','voyage','cuisine','histoire','technologie','japonais'];

test('web routes expose modern pages, categories, article and legacy redirects', () => {
  assert.ok(existsSync('app/Http/Controllers/ContentController.php'));
  const routes = readFileSync('routes/web.php','utf8');
  for (const path of expectedPaths) assert.ok(routes.includes(`'${path}'`) || routes.includes(`\"${path}\"`), `missing route ${path}`);
  for (const slug of categorySlugs) assert.ok(routes.includes(slug), `missing category ${slug}`);
  for (const legacy of ['manga-anime.html','culture.html','voyage.html','cuisine.html','histoire.html','technologie.html','japonais.html','recherche.html','favoris.html']) {
    assert.ok(routes.includes(legacy), `missing redirect ${legacy}`);
  }
  assert.match(routes, /301/);
});

test('content controller provides shared page actions', () => {
  const controller = readFileSync('app/Http/Controllers/ContentController.php','utf8');
  for (const method of ['home','category','article','search','favorites','legal','privacy']) {
    assert.match(controller, new RegExp(`function\\s+${method}\\s*\\(`), `missing ${method}`);
  }
});
