import test from 'node:test';
import assert from 'node:assert/strict';
import { existsSync, readFileSync } from 'node:fs';

const files = [
  'tests/Pest.php','tests/TestCase.php','tests/Feature/PublicPagesTest.php',
  'tests/Feature/SearchTest.php','tests/Feature/QuizTest.php','tests/Unit/SupportTest.php'
];

test('Pest suite covers public pages, content count, search and quiz', () => {
  for (const file of files) assert.ok(existsSync(file), `missing ${file}`);
  const publicPages = readFileSync('tests/Feature/PublicPagesTest.php','utf8');
  const search = readFileSync('tests/Feature/SearchTest.php','utf8');
  const quiz = readFileSync('tests/Feature/QuizTest.php','utf8');
  assert.match(publicPages,/Article::query\(\)->count\(\)/);
  assert.match(publicPages,/toBe\(40\)/);
  assert.match(publicPages,/assertStatus\(301\)/);
  assert.match(search,/GlobalSearch::class/);
  assert.match(search,/assertSee\('Ramen'\)/);
  assert.match(quiz,/JapaneseQuiz::class/);
  assert.match(quiz,/assertSet\('score', 1\)/);
});
