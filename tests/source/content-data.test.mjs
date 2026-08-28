import test from 'node:test';
import assert from 'node:assert/strict';
import { spawnSync } from 'node:child_process';
import { existsSync } from 'node:fs';

function loadPhpArray(path) {
  const code = `$data=require '${path}'; echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);`;
  const run = spawnSync('php', ['-r', code], { encoding: 'utf8' });
  assert.equal(run.status, 0, run.stderr);
  return JSON.parse(run.stdout);
}

test('article seed data contains exactly 40 unique slugs in 7 categories', () => {
  assert.ok(existsSync('database/data/articles.php'), 'database/data/articles.php missing');
  const articles = loadPhpArray('database/data/articles.php');
  assert.equal(articles.length, 40);
  assert.equal(new Set(articles.map((a) => a.slug)).size, 40);
  assert.deepEqual([...new Set(articles.map((a) => a.category))].sort(), [
    'cuisine', 'culture', 'histoire', 'japonais', 'manga-anime', 'technologie', 'voyage'
  ]);
  for (const article of articles) {
    assert.ok(article.title && article.excerpt && article.body);
    assert.ok(Array.isArray(article.keywords));
  }
});
