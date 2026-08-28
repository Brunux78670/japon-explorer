import test from 'node:test';
import assert from 'node:assert/strict';
import { existsSync, readFileSync } from 'node:fs';
import { spawnSync } from 'node:child_process';

const files = [
  'app/Support/TextNormalizer.php',
  'app/Services/SearchService.php',
  'app/Livewire/Search/GlobalSearch.php',
  'resources/views/livewire/search/global-search.blade.php',
];

test('search stack exists and Livewire uses debounced live input', () => {
  for (const file of files) assert.ok(existsSync(file), `missing ${file}`);
  const component = readFileSync('app/Livewire/Search/GlobalSearch.php','utf8');
  const view = readFileSync('resources/views/livewire/search/global-search.blade.php','utf8');
  const service = readFileSync('app/Services/SearchService.php','utf8');
  assert.match(component, /class GlobalSearch extends Component/);
  assert.match(component, /SearchService/);
  assert.match(view, /wire:model\.live\.debounce\.250ms="query"/);
  assert.match(service, /TextNormalizer::normalize/);
  assert.match(service, /take\(\$limit\)/);
});

test('text normalizer is accent-insensitive and lowercase', () => {
  const code = `require 'app/Support/TextNormalizer.php'; echo App\\Support\\TextNormalizer::normalize('Époque Jōmon — Tōkyō');`;
  const run = spawnSync('php',['-r',code],{encoding:'utf8'});
  assert.equal(run.status,0,run.stderr);
  assert.equal(run.stdout.trim(),'epoque jomon tokyo');
});
