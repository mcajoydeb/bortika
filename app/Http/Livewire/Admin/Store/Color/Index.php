<?php

namespace App\Http\Livewire\Admin\Store\Color;

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
        $this->totalItemsCount = Term::colors()->count();
        $this->activeItemsCount = Term::colors()->active()->count();
        $this->disabledItemsCount = Term::colors()->disabled()->count();
    }

    public function render()
    {
        $terms = Term::query()
            ->colors()
            ->status($this->statusFilter)
            ->search($this->search)
            ->latest()->paginate(20);

        return view('livewire.admin.store.color.index', compact('terms'));
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
