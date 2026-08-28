import test from 'node:test';
import assert from 'node:assert/strict';
import { existsSync, readFileSync } from 'node:fs';
import { spawnSync } from 'node:child_process';

const files = [
  'app/Models/Category.php','app/Models/Article.php','app/Models/QuizQuestion.php','app/Models/Favorite.php',
  'database/seeders/CategorySeeder.php','database/seeders/ArticleSeeder.php','database/seeders/QuizQuestionSeeder.php','database/seeders/DatabaseSeeder.php',
  'database/data/quiz.php'
];

test('models, migrations and seeders exist with expected relationships', () => {
  for (const file of files) assert.ok(existsSync(file), `missing ${file}`);
  const category = readFileSync('app/Models/Category.php','utf8');
  const article = readFileSync('app/Models/Article.php','utf8');
  const quiz = readFileSync('app/Models/QuizQuestion.php','utf8');
  assert.match(category, /function articles\(/);
  assert.match(article, /function category\(/);
  assert.match(article, /'keywords'\s*=>\s*'array'/);
  assert.match(quiz, /'choices'\s*=>\s*'array'/);
  const migrations = readFileSync('database/migrations/2026_08_27_000100_create_content_tables.php','utf8');
  for (const field of ['categories','articles','quiz_questions','favorites']) assert.match(migrations, new RegExp(field));
});

test('quiz seed data contains 8 valid questions', () => {
  const run = spawnSync('php',['-r',`$d=require 'database/data/quiz.php'; echo json_encode($d,JSON_UNESCAPED_UNICODE);`],{encoding:'utf8'});
  assert.equal(run.status,0,run.stderr);
  const data = JSON.parse(run.stdout);
  assert.equal(data.length,8);
  for (const q of data) {
    assert.equal(q.choices.length,4);
    assert.ok(q.correct_answer >= 0 && q.correct_answer < q.choices.length);
  }
});
