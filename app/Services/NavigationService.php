<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

class NavigationService
{
    /**
     * Checks whether the current route matches the provided route
     *
     * @param   string   $route_name     Route name to be checked
     * @return  string|null  active|null
     */
    public static function activeRouteName($route_name)
    {
        return (Route::currentRouteName() == $route_name) ? 'active' : null;
    }

    /**
     * Checks whether the current route matches the provided pattern
     *
     * @param   string   $route_pattern     Route pattern to be matched
     * @return  string|null  active|null
     */
    public static function activeRoutePattern($route_pattern)
    {
        return Request::is($route_pattern) ? 'active' : null;
    }
}
