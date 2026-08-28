<?php

namespace App\Livewire\Search;

use App\Services\SearchService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;

class GlobalSearch extends Component
{
    #[Url(as: 'q', history: true)]
    public string $query = '';

    public function render(SearchService $search): View
    {
        return view('livewire.search.global-search', [
            'results' => $search->search($this->query),
        ]);
    }
}
