import { writeFileSync } from 'node:fs';
import { CONTENT_ITEMS } from '../legacy-v1/assets/js/content.js';

const categories = new Map([
  ['Voyage', 'voyage'], ['Manga & Anime', 'manga-anime'], ['Culture', 'culture'],
  ['Cuisine', 'cuisine'], ['Histoire', 'histoire'], ['Technologie', 'technologie'], ['Japonais', 'japonais'],
]);
const featured = new Set(['tokyo', 'manga', 'shinto', 'ramen', 'samurai', 'shinkansen', 'hiragana']);
const images = {
  voyage: '/images/tokyo.svg',
  'manga-anime': '/images/hero-japan.svg',
  culture: '/images/kyoto.svg',
  cuisine: '/images/cuisine.svg',
  histoire: '/images/kyoto.svg',
  technologie: '/images/tokyo.svg',
  japonais: '/images/hero-japan.svg',
};

const articles = CONTENT_ITEMS.map((item) => {
  const category = categories.get(item.category);
  if (!category) throw new Error(`Unknown category: ${item.category}`);
  const [legacyPath, legacyAnchor = ''] = item.url.split('#');
  return {
    legacy_id: item.id,
    legacy_url: `/${legacyPath}${legacyAnchor ? `#${legacyAnchor}` : ''}`,
    category,
    title: item.title,
    slug: item.id,
    excerpt: item.summary,
    body: `${item.summary}\n\nCette fiche reprend le contenu de Japon Explorer V1 et sert de point de départ à une version éditoriale plus détaillée.`,
    keywords: item.keywords,
    image_path: images[category],
    image_alt: `Illustration de la rubrique ${item.category}`,
    is_featured: featured.has(item.id),
    published_at: '2026-08-27 00:00:00',
  };
});

writeFileSync('database/data/articles.json', JSON.stringify(articles, null, 2) + '\n');
