<?php

namespace App\Pipelines\Admin\User;

use Closure;
use Illuminate\Support\Facades\Hash;

class HashUserPassword
{
    public function handle($data, Closure $next)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        return $next($data);
    }
}
