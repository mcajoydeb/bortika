<?php

namespace App\View\Components\Admin\Alert;

use Illuminate\View\Component;

class Alert extends Component
{
    public $message;
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (session()->has('alert-success')) {
            $this->message = session()->get('alert-success');
            $this->type = 'success';
        } elseif (session()->has('alert-message')) {
            $this->message = session()->get('alert-message');
            $this->type = 'primary';
        } elseif (session()->has('alert-warning')) {
            $this->message = session()->get('alert-warning');
            $this->type = 'warning';
        } elseif (session()->has('alert-error')) {
            $this->message = session()->get('alert-error');
            $this->type = 'danger';
        } else {
            $this->type = 'primary';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.alert.alert');
    }
}
