<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class Summernote extends Component
{
    public $inputName;
    public $showCountClassName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($inputName, $showCountClassName)
    {
        $this->inputName = $inputName;
        $this->showCountClassName = $showCountClassName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.form.summernote');
    }
}
