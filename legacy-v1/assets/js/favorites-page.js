import { readFavorites, removeFavorite } from './favorites.js';
import { getContentById } from './content.js';
const list=document.querySelector('#favorites-list'); const empty=document.querySelector('#favorites-empty'); const status=document.querySelector('#favorites-status');
function render(){
  try {
    const ids=readFavorites(localStorage); const items=ids.map(getContentById).filter(Boolean); list.replaceChildren(); empty.hidden=items.length>0; status.textContent=`${items.length} favori${items.length>1?'s':''}`;
    for(const item of items){
      const card=document.createElement('article'); card.className='card';
      const badge=document.createElement('span'); badge.className='badge'; badge.textContent=item.category;
      const h=document.createElement('h3'); const a=document.createElement('a'); a.href=item.url; a.textContent=item.title; h.append(a);
      const p=document.createElement('p'); p.textContent=item.summary;
      const b=document.createElement('button'); b.className='button button--ghost button--small'; b.type='button'; b.textContent='Retirer'; b.addEventListener('click',()=>{ removeFavorite(localStorage,item.id); render(); });
      card.append(badge,h,p,b); list.append(card);
    }
  } catch { status.textContent='Le stockage local est indisponible sur ce navigateur.'; }
}
render();
