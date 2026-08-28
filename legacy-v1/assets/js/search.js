export function normalizeText(value = '') {
  return String(value).normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
}

export function searchItems(items, query) {
  const tokens = normalizeText(query).split(/\s+/).filter(Boolean);
  if (!tokens.length) return [];
  return items.filter((item) => {
    const haystack = normalizeText([item.title, item.summary, ...(item.keywords || [])].join(' '));
    return tokens.every((token) => haystack.includes(token));
  });
}
