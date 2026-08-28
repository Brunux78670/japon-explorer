import test from 'node:test';
import assert from 'node:assert/strict';
import { existsSync } from 'node:fs';
import { spawnSync } from 'node:child_process';

const archive = 'dist/site-japon-laravel-source.zip';

test('source archive exists, contains Laravel project, and excludes generated/secrets folders', () => {
  assert.ok(existsSync(archive), `missing ${archive}`);
  const run = spawnSync('unzip',['-Z1',archive],{encoding:'utf8'});
  assert.equal(run.status,0,run.stderr);
  const entries = run.stdout.trim().split(/\r?\n/);
  for (const required of ['composer.json','artisan','bootstrap/app.php','app/Models/Article.php','resources/views/pages/home.blade.php','legacy-v1/index.html','README.md','BUILD-STATUS.md']) {
    assert.ok(entries.includes(required), `archive missing ${required}`);
  }
  for (const forbidden of ['.env','.git']) assert.ok(!entries.includes(forbidden), `archive contains ${forbidden}`);
  assert.ok(!entries.some((e)=>e.startsWith('vendor/')), 'archive contains vendor');
  assert.ok(!entries.some((e)=>e.startsWith('node_modules/')), 'archive contains node_modules');
  assert.ok(!entries.some((e)=>e.startsWith('.worktrees/')), 'archive contains .worktrees');
});
