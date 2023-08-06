<?php

namespace App\Http\Livewire\Admin\Store\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $totalItemsCount;
    public $activeItemsCount;
    public $disabledItemsCount;
    public $trashedItemsCount;
    public $statusFilter;
    public $trashFilter;
    public $search;

    public function mount()
    {
        $this->totalItemsCount = Product::loggedOwner()->withTrashed()->count();
        $this->activeItemsCount = Product::loggedOwner()->active()->count();
        $this->disabledItemsCount = Product::loggedOwner()->disabled()->count();
        $this->trashedItemsCount = Product::loggedOwner()->onlyTrashed()->count();
    }

    public function render()
    {
        $products = Product::query()
            ->with('extra')
            ->status($this->statusFilter)
            ->trash($this->trashFilter)
            ->search($this->search)
            ->excludeVariations()
            ->loggedOwner()
            ->latest()
            ->paginate(20);

        return view('livewire.admin.store.product.index', compact('products'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setFilter($type, $value)
    {
        $this->resetPage();
        if ($type == 'status') {
            $this->statusFilter = $value;
            $this->trashFilter = false;
        } elseif ($type == 'trash') {
            $this->statusFilter = null;
            $this->trashFilter = $value;
        }
    }
}
