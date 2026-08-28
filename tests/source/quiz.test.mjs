import test from 'node:test';
import assert from 'node:assert/strict';
import { existsSync, readFileSync } from 'node:fs';
import { spawnSync } from 'node:child_process';

test('quiz engine scores correct and incorrect answers', () => {
  assert.ok(existsSync('app/Support/QuizEngine.php'));
  const code = `require 'app/Support/QuizEngine.php'; $q=['correct_answer'=>1,'explanation'=>'Parce que.']; echo json_encode([App\\Support\\QuizEngine::evaluate($q,1),App\\Support\\QuizEngine::evaluate($q,0)]);`;
  const run = spawnSync('php',['-r',code],{encoding:'utf8'});
  assert.equal(run.status,0,run.stderr);
  const [right, wrong] = JSON.parse(run.stdout);
  assert.equal(right.correct,true);
  assert.equal(wrong.correct,false);
  assert.equal(right.explanation,'Parce que.');
});

test('Livewire quiz exposes actions but not correct answer in Blade markup', () => {
  const componentPath = 'app/Livewire/Japanese/Quiz.php';
  const viewPath = 'resources/views/livewire/japanese/quiz.blade.php';
  assert.ok(existsSync(componentPath));
  assert.ok(existsSync(viewPath));
  const component = readFileSync(componentPath,'utf8');
  const view = readFileSync(viewPath,'utf8');
  assert.match(component,/function answer\(/);
  assert.match(component,/function next\(/);
  assert.match(component,/function restart\(/);
  assert.match(component,/QuizEngine::evaluate/);
  assert.match(view,/wire:click="answer\(/);
  assert.doesNotMatch(view,/correct_answer/);
  assert.match(view,/aria-live="polite"/);
});
