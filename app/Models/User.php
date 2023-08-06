<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->id,
            'password' => 'filled|string|confirmed|min:8',
        ];
    }

    public function scopeTrash($query, $showOnlyTrashed = false)
    {
        if ($showOnlyTrashed) {
            return $query->onlyTrashed();
        }

        return $query;
    }

    public function scopeSearch($query, $value)
    {
        if (!empty($value)) {
            return $query->where('name', 'LIKE', "%{$value}%")->orWhere('email', 'LIKE', "%{$value}%");
        }

        return $query;
    }

    public function scopeExceptSuperAdmin($query)
    {
        $query->notRole(config('roles.super_admin.id'));
    }

    public function scopeNotRole($query, $roles, $guard = null)
    {
         if ($roles instanceof Collection) {
             $roles = $roles->all();
         }

         if (! is_array($roles)) {
             $roles = [$roles];
         }

         $roles = array_map(function ($role) use ($guard) {
             if ($role instanceof Role) {
                 return $role;
             }

             $method = is_numeric($role) ? 'findById' : 'findByName';
             $guard = $guard ?: $this->getDefaultGuardName();

             return $this->getRoleClass()->{$method}($role, $guard);
         }, $roles);

         return $query->whereHas('roles', function ($query) use ($roles) {
             $query->where(function ($query) use ($roles) {
                 foreach ($roles as $role) {
                     $query->where(config('permission.table_names.roles').'.id', '!=' , $role->id);
                 }
             });
         });
    }

    public function scopeNotLoggedUser($query)
    {
        return $query->whereNotIn('id', [Auth::user()->id]);
    }
}
