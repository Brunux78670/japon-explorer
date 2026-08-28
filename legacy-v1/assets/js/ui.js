import { isFavorite, addFavorite, removeFavorite } from './favorites.js';

const toggle = document.querySelector('[data-menu-toggle]');
const nav = document.querySelector('[data-site-nav]');
if (toggle && nav) {
  const close = () => { nav.classList.remove('is-open'); toggle.setAttribute('aria-expanded','false'); };
  toggle.addEventListener('click', () => {
    const open = !nav.classList.contains('is-open');
    nav.classList.toggle('is-open', open);
    toggle.setAttribute('aria-expanded', String(open));
  });
  document.addEventListener('keydown', (event) => { if (event.key === 'Escape') close(); });
  nav.addEventListener('click', (event) => { if (event.target.closest('a')) close(); });
}

function syncFavoriteButton(button) {
  const id = button.dataset.favoriteId;
  let active = false;
  try { active = isFavorite(localStorage, id); } catch { active = false; }
  button.setAttribute('aria-pressed', String(active));
  button.textContent = active ? '♥ Dans mes favoris' : '♡ Ajouter aux favoris';
}

document.querySelectorAll('[data-favorite-id]').forEach((button) => {
  syncFavoriteButton(button);
  button.addEventListener('click', () => {
    try {
      const id = button.dataset.favoriteId;
      isFavorite(localStorage, id) ? removeFavorite(localStorage, id) : addFavorite(localStorage, id);
      document.querySelectorAll(`[data-favorite-id="${CSS.escape(id)}"]`).forEach(syncFavoriteButton);
    } catch {
      button.textContent = 'Favoris indisponibles';
    }
  });
});

const reduced = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches;
const revealItems = [...document.querySelectorAll('[data-reveal]')];
if (reduced || !('IntersectionObserver' in window)) revealItems.forEach((el) => el.classList.add('is-visible'));
else {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => { if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); } });
  }, { threshold:.08 });
  revealItems.forEach((el) => observer.observe(el));
}
