import { CONTENT_ITEMS } from './content.js';
import { searchItems } from './search.js';
const form = document.querySelector('[data-search-form]');
const input = form?.querySelector('input[name="q"]');
const results = document.querySelector('#search-results');
const status = document.querySelector('#search-status');

function render(query) {
  const found = searchItems(CONTENT_ITEMS, query);
  results.replaceChildren();
  status.textContent = query ? `${found.length} résultat${found.length > 1 ? 's' : ''} pour « ${query} »` : 'Saisissez un mot-clé pour explorer le site.';
  if (!query) return;
  if (!found.length) {
    const empty = document.createElement('div'); empty.className='empty-state'; empty.textContent='Aucun résultat. Essayez Tokyo, ramen, manga, samouraï ou hiragana.'; results.append(empty); return;
  }
  for (const item of found) {
    const article=document.createElement('article'); article.className='card';
    const badge=document.createElement('span'); badge.className='badge'; badge.textContent=item.category;
    const h=document.createElement('h3'); const a=document.createElement('a'); a.href=item.url; a.textContent=item.title; h.append(a);
    const p=document.createElement('p'); p.textContent=item.summary;
    article.append(badge,h,p); results.append(article);
  }
}
const initial = new URLSearchParams(location.search).get('q')?.trim() || '';
if (input) input.value=initial; render(initial);
form?.addEventListener('submit',(event)=>{ event.preventDefault(); const q=input.value.trim(); history.replaceState(null,'',q?`?q=${encodeURIComponent(q)}`:'recherche.html'); render(q); });
