<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnauthorisedRolesForBackendMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // logout if user has no valid backend roles
        if (auth()->check() && auth()->user()->hasAnyRole([config('roles.user.id')])) {
            Auth::logout();
            return redirect()->route('home');
        }

        return $next($request);
    }
}
