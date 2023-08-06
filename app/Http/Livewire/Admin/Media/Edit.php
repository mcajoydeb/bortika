<?php

namespace App\Http\Livewire\Admin\Media;

use Livewire\Component;

class Edit extends Component
{
    public $media;

    public function mount($media)
    {
        $this->media = $media;
    }

    public function render()
    {
        return view('livewire.admin.media.edit');
    }
}
