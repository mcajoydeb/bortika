<?php

namespace App\View\Components\Admin\Table;

use Illuminate\View\Component;

class NoRecordFound extends Component
{
    public $message;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message = null)
    {
        $this->message = trans('table-messages.no-records-found');

        if ($message) {
            $this->message = $message;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.table.no-record-found');
    }
}
