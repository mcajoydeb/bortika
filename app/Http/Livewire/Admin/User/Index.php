<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $totalItemsCount;
    public $trashedItemsCount;
    public $trashFilter;
    public $search;

    public function mount()
    {
        $this->totalItemsCount = User::exceptSuperAdmin()
            ->notLoggedUser()
            ->withTrashed()
            ->count();

        $this->trashedItemsCount = User::onlyTrashed()->count();
    }

    public function render()
    {
        $users = User::exceptSuperAdmin()
            ->notLoggedUser()
            ->trash($this->trashFilter)
            ->search($this->search)
            ->latest()->paginate(20);

        return view('livewire.admin.user.index', compact('users'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
