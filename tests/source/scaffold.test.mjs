import test from 'node:test';
import assert from 'node:assert/strict';
import { existsSync, readFileSync } from 'node:fs';

const required = [
  'composer.json', 'artisan', 'bootstrap/app.php', 'public/index.php',
  'routes/web.php', 'routes/console.php', 'package.json', 'vite.config.js',
  'legacy-v1/assets/js/content.js', 'legacy-v1/assets/data/search-index.json'
];

test('Laravel source scaffold and archived V1 are present', () => {
  for (const file of required) assert.ok(existsSync(file), `missing ${file}`);
});

test('composer targets Laravel 13 and Livewire 4 on PHP >=8.3', () => {
  const composer = JSON.parse(readFileSync('composer.json', 'utf8'));
  assert.match(composer.require.php, /\^8\.3/);
  assert.match(composer.require['laravel/framework'], /\^13/);
  assert.match(composer.require['livewire/livewire'], /\^4/);
});

test('frontend uses Vite and Tailwind CSS 4', () => {
  const pkg = JSON.parse(readFileSync('package.json', 'utf8'));
  assert.match(pkg.devDependencies.tailwindcss, /\^4/);
  assert.ok(pkg.devDependencies['@tailwindcss/vite']);
  assert.ok(pkg.devDependencies['laravel-vite-plugin']);
});

test('Laravel runtime provider registry and writable storage placeholders are packaged', () => {
  for (const file of [
    'bootstrap/providers.php',
    'storage/framework/cache/.gitignore',
    'storage/framework/sessions/.gitignore',
    'storage/framework/views/.gitignore',
    'storage/logs/.gitignore'
  ]) assert.ok(existsSync(file), `missing ${file}`);
});
