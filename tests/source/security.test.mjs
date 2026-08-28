import test from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { execFileSync } from 'node:child_process';

test('environment secrets stay out of Git and session security remains configurable', () => {
  const ignored = readFileSync('.gitignore','utf8');
  assert.match(ignored, /^\.env$/m);
  const example = readFileSync('.env.example','utf8');
  assert.match(example, /^APP_KEY=$/m);
  assert.doesNotMatch(example, /^APP_KEY=base64:/m);
  const session = readFileSync('config/session.php','utf8');
  assert.match(session,/SESSION_SECURE_COOKIE/);
  assert.match(session,/SESSION_HTTP_ONLY/);
  assert.match(session,/SESSION_SAME_SITE/);
  const tracked = execFileSync('git',['ls-files'],{encoding:'utf8'}).split(/\r?\n/);
  assert.ok(!tracked.includes('.env'));
});

test('article body is escaped before line-break rendering', () => {
  const article = readFileSync('resources/views/pages/article.blade.php','utf8');
  assert.match(article,/nl2br\(e\(\$article->body\)\)/);
  assert.doesNotMatch(article,/{!!\s*\$article->body\s*!!}/);
});

test('local defaults run without database-backed cache/session/queue infrastructure', () => {
  const example = readFileSync('.env.example','utf8');
  assert.match(example,/^SESSION_DRIVER=file$/m);
  assert.match(example,/^CACHE_STORE=file$/m);
  assert.match(example,/^QUEUE_CONNECTION=sync$/m);
});
