import test from 'node:test';
import assert from 'node:assert/strict';
import { existsSync, readFileSync } from 'node:fs';

test('SEO has canonical, robots policy and dynamic sitemap source', () => {
  const layout = readFileSync('resources/views/components/layouts/app.blade.php','utf8');
  assert.match(layout, /rel="canonical"/);
  assert.match(layout, /property="og:title"/);
  assert.ok(existsSync('public/robots.txt'));
  const robots = readFileSync('public/robots.txt','utf8');
  assert.match(robots,/User-agent:\s*\*/);
  assert.match(robots,/Disallow:\s*\/recherche/);
  assert.match(robots,/Disallow:\s*\/favoris/);
  assert.ok(existsSync('resources/views/sitemap.blade.php'));
  const sitemap = readFileSync('resources/views/sitemap.blade.php','utf8');
  assert.match(sitemap, /urlset/);
  assert.match(sitemap, /\$categories/);
  assert.match(sitemap, /\$articles/);
  const routes = readFileSync('routes/web.php','utf8');
  assert.match(routes, /Content-Type/);
  assert.match(routes, /application\/xml/);
});
