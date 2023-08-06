<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class SubmitButton extends Component
{
    public $entity;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.form.submit-button');
    }
}
