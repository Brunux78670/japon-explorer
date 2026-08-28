import test from 'node:test';
import assert from 'node:assert/strict';

class MemoryStorage {
  #data = new Map();
  getItem(key) { return this.#data.has(key) ? this.#data.get(key) : null; }
  setItem(key, value) { this.#data.set(key, String(value)); }
  removeItem(key) { this.#data.delete(key); }
}

test('favorites toggle add/remove without duplicates', async () => {
  const { readFavorites, toggleFavorite, FAVORITES_KEY } = await import('../../resources/js/favorites.js');
  const storage = new MemoryStorage();
  assert.equal(FAVORITES_KEY, 'japon-explorer:favorites:v2');
  assert.deepEqual(readFavorites(storage), []);
  assert.equal(toggleFavorite('tokyo', storage), true);
  assert.equal(toggleFavorite('tokyo', storage), false);
  assert.deepEqual(readFavorites(storage), []);
  toggleFavorite('tokyo', storage);
  toggleFavorite('ramen', storage);
  toggleFavorite('ramen', storage);
  toggleFavorite('ramen', storage);
  assert.deepEqual(readFavorites(storage).sort(), ['ramen','tokyo']);
});

test('favorites reader sanitizes corrupt and duplicate values', async () => {
  const { readFavorites, FAVORITES_KEY } = await import('../../resources/js/favorites.js');
  const storage = new MemoryStorage();
  storage.setItem(FAVORITES_KEY, JSON.stringify(['tokyo','tokyo','',12,'ramen']));
  assert.deepEqual(readFavorites(storage), ['tokyo','ramen']);
  storage.setItem(FAVORITES_KEY, '{bad json');
  assert.deepEqual(readFavorites(storage), []);
});
