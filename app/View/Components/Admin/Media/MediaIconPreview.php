<?php

namespace App\View\Components\Admin\Media;

use Illuminate\View\Component;

class MediaIconPreview extends Component
{
    public $media;
    public $showTitle;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($media, $showTitle = true)
    {
        $this->media = $media;
        $this->showTitle = $showTitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.media.media-icon-preview');
    }
}
