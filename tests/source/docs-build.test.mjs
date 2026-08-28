import test from 'node:test';
import assert from 'node:assert/strict';
import { existsSync, readFileSync } from 'node:fs';

test('README documents full Laravel install and verification workflow', () => {
  const readme = readFileSync('README.md','utf8');
  for (const command of ['composer install','npm install','php artisan key:generate','php artisan migrate --seed','npm run build','php artisan serve','php artisan test','vendor/bin/pint --test']) {
    assert.ok(readme.includes(command), `README missing: ${command}`);
  }
  assert.match(readme,/SQLite/);
  assert.match(readme,/MySQL|MariaDB/);
  assert.match(readme,/PHP 8\.5/);
});

test('project provides standalone source verification and packaging scripts', () => {
  assert.ok(existsSync('scripts/verify-source.mjs'));
  assert.ok(existsSync('scripts/package.sh'));
  const packageScript = readFileSync('scripts/package.sh','utf8');
  for (const excluded of ['.git','vendor','node_modules','.env']) assert.ok(packageScript.includes(excluded), `package script must exclude ${excluded}`);
});
