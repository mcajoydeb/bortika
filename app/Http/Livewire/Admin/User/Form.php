<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Form extends Component
{
    public $user;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $roles;
    public $showPassword = true;

    public function rules()
    {
        if ($this->user) {
            $rules = User::find($this->user->id)->rules();
        } else {
            $rules = (new User)->rules();
        }

        if (!$this->showPassword) {
            unset($rules['password']);
        }

        return $rules;

    }

    public function mount()
    {
        if (old('name')) {
            $this->initializeData('old');
        } elseif ($this->user) {
            $this->showPassword = false;
            $this->initializeData('user');
        }
    }

    public function initializeData($type)
    {
        $this->name = ($type == 'old') ? old('name') : $this->user->name;
        $this->email = ($type == 'old') ? old('email') : $this->user->email;
        $this->roles = ($type == 'old') ? old('roles') : $this->user->getRoleNames()->toArray();
        // dd($this->roles);
    }

    public function render()
    {
        $allRoles = Role::where('name', '<>', config('roles.super_admin.id'))->pluck('name', 'name')->toArray();
        return view('livewire.admin.user.form', compact('allRoles'));
    }

    public function updated()
    {
        $this->validate();
    }
}
