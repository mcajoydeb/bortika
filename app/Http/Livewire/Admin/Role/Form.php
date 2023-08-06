<?php

namespace App\Http\Livewire\Admin\Role;

use Livewire\Component;

class Form extends Component
{
    public $role;
    public $name;
    public $permissions = [];
    public $selectAll = false;

    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:roles,name,' . ($this->role ? $this->role->id : ''),
            'permissions' => 'present|array'
        ];
    }

    public function mount()
    {
        if (old('name')) {
            $this->initializeData('old');
        } elseif ($this->role) {
            $this->initializeData('role');
        }
    }

    public function initializeData($type)
    {
        $this->name = ($type == 'old') ? old('name') : $this->role->name;
        $this->permissions = ($type == 'old') ? (old('permissions') ? old('permissions') : []) : $this->role->getPermissionNames()->toArray();
    }

    public function render()
    {
        return view('livewire.admin.role.form');
    }

    public function updated($attribute)
    {
        if ($attribute == 'selectAll') {
            if ($this->selectAll) {
                $this->permissions = config('permissions-list');
            } else {
                $this->permissions = [];
            }
        }
        $this->validate($this->rules());
    }
}
