import { readdirSync, readFileSync, statSync } from 'node:fs';
import { spawnSync } from 'node:child_process';
import path from 'node:path';

const root = path.resolve(import.meta.dirname, '..');
process.chdir(root);

function fail(message) {
  console.error(`✗ ${message}`);
  process.exit(1);
}

function run(command, args) {
  const result = spawnSync(command, args, { encoding: 'utf8', stdio: ['ignore', 'pipe', 'pipe'] });
  if (result.status !== 0) {
    process.stdout.write(result.stdout ?? '');
    process.stderr.write(result.stderr ?? '');
    fail(`${command} ${args.join(' ')}`);
  }
  return result.stdout;
}

function walk(directory, predicate, out = []) {
  if (!statSync(directory).isDirectory()) return out;
  for (const name of readdirSync(directory)) {
    const full = path.join(directory, name);
    const stat = statSync(full);
    if (stat.isDirectory()) walk(full, predicate, out);
    else if (predicate(full)) out.push(full);
  }
  return out;
}

for (const jsonFile of ['composer.json', 'package.json', 'database/data/articles.json']) {
  JSON.parse(readFileSync(jsonFile, 'utf8'));
}
console.log('✓ JSON valide');

const sourceTests = readdirSync('tests/source').filter((name) => name.endsWith('.test.mjs')).sort().map((name) => `tests/source/${name}`);
run('node', ['--test', ...sourceTests]);
console.log(`✓ ${sourceTests.length} fichiers de tests source exécutés`);

const phpRoots = ['app', 'bootstrap', 'config', 'database', 'routes', 'tests/Feature', 'tests/Unit'];
let phpFiles = [];
for (const directory of phpRoots) phpFiles.push(...walk(directory, (file) => file.endsWith('.php')));
phpFiles.push('tests/Pest.php', 'tests/TestCase.php', 'public/index.php', 'artisan');
phpFiles = [...new Set(phpFiles)].sort();
for (const file of phpFiles) run('php', ['-l', file]);
console.log(`✓ ${phpFiles.length} fichiers PHP sans erreur de syntaxe`);

const count = run('php', ['-r', "$d=require 'database/data/articles.php'; echo count($d);"]).trim();
if (count !== '40') fail(`catalogue attendu: 40, obtenu: ${count}`);
console.log('✓ 40 articles migrés');

console.log('Validation source terminée avec succès.');
