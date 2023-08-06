<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    public function setLocale(Request $request, $locale)
    {
        Cookie::queue(Cookie::forever('locale', $locale));
        return redirect()->back();
    }

    public function sidebarCollapse(Request $request)
    {
        if ($request->is_collapsed == 'true') {
            Cookie::queue(Cookie::forever('sidebar-collapse', 'sidebar-collapse'));
        } else {
            Cookie::queue(Cookie::forever('sidebar-collapse', ''));
        }

        return response()->json([
            'status' => 'success',
            'is_collapsed' => $request->is_collapsed,
        ]);
    }
}
