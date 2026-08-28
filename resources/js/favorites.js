export const FAVORITES_KEY = 'japon-explorer:favorites:v2';

export function readFavorites(storage = window.localStorage) {
    try {
        const raw = storage?.getItem(FAVORITES_KEY);
        if (!raw) return [];
        const value = JSON.parse(raw);
        if (!Array.isArray(value)) return [];
        return [...new Set(value.filter((slug) => typeof slug === 'string' && slug.trim() !== '').map((slug) => slug.trim()))];
    } catch {
        return [];
    }
}

export function writeFavorites(slugs, storage = window.localStorage) {
    const clean = [...new Set(slugs.filter((slug) => typeof slug === 'string' && slug.trim() !== '').map((slug) => slug.trim()))];
    try { storage?.setItem(FAVORITES_KEY, JSON.stringify(clean)); } catch { /* localStorage can be disabled */ }
    return clean;
}

export function isFavorite(slug, storage = window.localStorage) {
    return readFavorites(storage).includes(slug);
}

export function toggleFavorite(slug, storage = window.localStorage) {
    const current = readFavorites(storage);
    const active = current.includes(slug);
    writeFavorites(active ? current.filter((item) => item !== slug) : [...current, slug], storage);
    return !active;
}

function updateButton(button) {
    const slug = button.dataset.favoriteSlug;
    const active = isFavorite(slug);
    button.setAttribute('aria-pressed', active ? 'true' : 'false');
    button.setAttribute('aria-label', active ? `Retirer ${slug} des favoris` : `Ajouter ${slug} aux favoris`);
    button.querySelector('[data-favorite-icon]').textContent = active ? '♥' : '♡';
    button.classList.toggle('favorite-active', active);
}

function syncButtons(root = document) {
    root.querySelectorAll('[data-favorite-button]').forEach(updateButton);
}

function renderFavoritesPage() {
    const page = document.querySelector('[data-favorites-page]');
    if (!page) return;
    const favorites = new Set(readFavorites());
    let visible = 0;
    page.querySelectorAll('[data-favorite-card]').forEach((card) => {
        const show = favorites.has(card.dataset.favoriteSlug);
        card.hidden = !show;
        if (show) visible += 1;
    });
    const empty = page.querySelector('[data-favorites-empty]');
    if (empty) empty.hidden = visible !== 0;
}

function initFavorites() {
    syncButtons();
    renderFavoritesPage();
    document.addEventListener('click', (event) => {
        const button = event.target.closest('[data-favorite-button]');
        if (!button) return;
        toggleFavorite(button.dataset.favoriteSlug);
        syncButtons();
        renderFavoritesPage();
        document.dispatchEvent(new CustomEvent('japon:favorite-changed', { detail: { slug: button.dataset.favoriteSlug } }));
    });
}

if (typeof document !== 'undefined') {
    document.addEventListener('DOMContentLoaded', initFavorites, { once: true });
}
