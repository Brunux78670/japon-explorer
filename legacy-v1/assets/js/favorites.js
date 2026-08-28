const STORAGE_KEY = 'japon-explorer:favorites';

export function readFavorites(storage) {
  try {
    const raw = storage?.getItem(STORAGE_KEY);
    if (!raw) return [];
    const value = JSON.parse(raw);
    return Array.isArray(value) ? [...new Set(value.filter((id) => typeof id === 'string'))] : [];
  } catch { return []; }
}

function writeFavorites(storage, ids) {
  try { storage?.setItem(STORAGE_KEY, JSON.stringify(ids)); } catch { /* non-blocking */ }
  return ids;
}

export function isFavorite(storage, id) { return readFavorites(storage).includes(id); }
export function addFavorite(storage, id) {
  const ids = [...new Set([...readFavorites(storage), id])];
  return writeFavorites(storage, ids);
}
export function removeFavorite(storage, id) {
  const ids = readFavorites(storage).filter((item) => item !== id);
  return writeFavorites(storage, ids);
}
