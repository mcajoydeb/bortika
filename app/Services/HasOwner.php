<?php

namespace App\Services;

trait HasOwner
{
    public function scopeLoggedOwner($query, $field = 'user_id')
    {
        if (auth()->user()->hasRole(config('roles.super_admin.id'))) {
            return $query;
        } else {
            return $query->where($field, auth()->user()->id);
        }
    }
}
