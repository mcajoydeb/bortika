<?php

namespace App\Http\Livewire\Admin\Utilities;

use App\Models\Media;
use Livewire\Component;

class ChooseMedia extends Component
{
    public $inputName;
    public $inputValue;
    public $media;
    public $multiple;
    public $allowedType;

    protected $listeners = [ 'mediaUpdated' => 'setSelectMedia' ];

    public function mount($inputName, $inputValue, $multiple = false, $allowedType = ['image'])
    {
        $this->inputName = $inputName;
        $this->inputValue = ($multiple && empty($inputValue)) ? [] : $inputValue;
        $this->multiple = $multiple;
        $this->media = $this->getMedia();
        $this->allowedType = $allowedType;
    }

    public function render()
    {
        return view('livewire.admin.utilities.choose-media');
    }

    public function setSelectMedia($inputValue)
    {
        $this->inputValue = $inputValue;
        $this->media = $this->getMedia();
    }

    public function getMedia()
    {
        if ($this->multiple) {
            return Media::whereIn('id', $this->inputValue)->get();
        } else {
            return Media::find($this->inputValue);
        }
    }
}
