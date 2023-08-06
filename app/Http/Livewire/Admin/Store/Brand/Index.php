<?php

namespace App\Http\Livewire\Admin\Store\Brand;

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
        $this->totalItemsCount = Term::brands()->count();
        $this->activeItemsCount = Term::brands()->active()->count();
        $this->disabledItemsCount = Term::brands()->disabled()->count();
    }

    public function render()
    {
        $terms = Term::query()
            ->brands()
            ->status($this->statusFilter)
            ->search($this->search)
            ->latest()->paginate(20);

        return view('livewire.admin.store.brand.index', compact('terms'));
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
