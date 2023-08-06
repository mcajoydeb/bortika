<?php

namespace App\Http\Livewire\Admin\Media;

use App\Models\Media;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $totalItemsCount;
    public $imageItemsCount;
    public $videoItemsCount;
    public $textItemsCount;
    public $typeFilter;
    public $search;

    public function mount()
    {
        $this->totalItemsCount = Media::count();
        $this->imageItemsCount = Media::image()->count();
        $this->videoItemsCount = Media::video()->count();
        $this->textItemsCount = Media::text()->count();
    }

    public function render()
    {
        $media = Media::with('owner')->type($this->typeFilter)->search($this->search)
            ->latest()->paginate(20);

        return view('livewire.admin.media.index', compact('media'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setTypeFilter($value)
    {
        $this->resetPage();
        $this->typeFilter = $value;
    }
}
