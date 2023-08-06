<?php

namespace App\Http\Livewire\Admin\Blog\Category;

use App\Models\Term;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $totalItemsCount;
    public $activeItemsCount;
    public $disabledItemsCount;
    public $statusFilter;
    public $search;

    public function mount()
    {
        $this->totalItemsCount = Term::postCategories()->count();
        $this->activeItemsCount = Term::postCategories()->active()->count();
        $this->disabledItemsCount = Term::postCategories()->disabled()->count();
    }

    public function render()
    {
        $terms = Term::query()
            ->postCategories()
            ->status($this->statusFilter)
            ->search($this->search)
            ->latest()->paginate(20);

        return view('livewire.admin.blog.category.index', compact('terms'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setFilter($value)
    {
        $this->resetPage();
        $this->statusFilter = $value;
    }
}
