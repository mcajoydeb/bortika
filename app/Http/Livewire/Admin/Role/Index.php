<?php

namespace App\Http\Livewire\Admin\Role;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';

    public $search;

    public function render()
    {
        $roles = new Role;

        if ($this->search) {
            $roles = $roles->where('name', 'LIKE', "%{$this->search}%");
        }

        $rolesToExclude = Auth::user()->getRoleNames()->toArray();
        $rolesToExclude[] = config('roles.super_admin.id');

        $roles = $roles->whereNotIn('name', $rolesToExclude)
            ->latest()
            ->paginate(20);

        return view('livewire.admin.role.index', compact('roles'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
