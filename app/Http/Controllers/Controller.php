<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use JavaScript;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        JavaScript::put([
            'sidebar_collpase_route' => route('admin.sidebar.collapse'),
            'confirmation_title' => trans('form-actions.confirmation_title'),
            'delete_confirmation' => trans('form-actions.delete_confirmation'),
            'delete_action_title' => trans('form-actions.delete'),
        ]);
    }
}
