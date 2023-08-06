<?php

namespace App\Http\Livewire\Admin\Store\Attribute;

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
        $this->totalItemsCount = Term::attributes()->count();
        $this->activeItemsCount = Term::attributes()->active()->count();
        $this->disabledItemsCount = Term::attributes()->disabled()->count();
    }

    public function render()
    {
        $terms = Term::query()
            ->attributes()
            ->status($this->statusFilter)
            ->search($this->search)
            ->latest()->paginate(20);

        return view('livewire.admin.store.attribute.index', compact('terms'));
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
