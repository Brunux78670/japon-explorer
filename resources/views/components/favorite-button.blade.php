@props(['article'])
<button type="button" data-favorite-button data-favorite-slug="{{ $article->slug }}" aria-pressed="false"
        class="favorite-button" title="Ajouter ou retirer des favoris">
    <span data-favorite-icon aria-hidden="true">♡</span>
</button>
