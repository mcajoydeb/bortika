<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Blog extends Component
{
    use WithPagination;

    /** @var string */
    protected $paginationTheme = 'bootstrap';

    /** @var string */
    public $search;

    /** @var array */
    public $selectedItems = [];

    /** @var array */
    protected $listeners = ['categoryItemSelected' => 'updateCategoriesSelected'];

    public function mount()
    {
        $this->search = null;
        $this->selectedItems = [];
    }

    public function render()
    {
        $posts = Post::query()
            ->with(['extra', 'comments'])
            ->publish()
            ->search($this->search)
            ->latest()
            ->termIds($this->selectedItems)
            ->select('posts.*')
            ->paginate(10);

        return view('livewire.frontend.blog', compact('posts'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateCategoriesSelected($selectedItems)
    {
        $this->selectedItems = $selectedItems;
    }
}
