<?php

namespace App\Http\Livewire\Admin\Utilities;

use App\Models\Media;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class MediaListing extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $inputName;
    public $allowedType;
    public $multiple;

    public $totalItemsCount;
    public $imageItemsCount;
    public $videoItemsCount;
    public $textItemsCount;

    public $selectedFile;
    public $uploadMode;
    public $typeFilter;
    public $search;

    public function mount($inputName, $selectedFile, $allowedType = [], $multiple = false)
    {
        $this->inputName = $inputName;
        $this->allowedType = $allowedType;
        $this->multiple = $multiple;

        $this->totalItemsCount = Media::count();
        $this->imageItemsCount = Media::image()->count();
        $this->videoItemsCount = Media::video()->count();
        $this->textItemsCount = Media::text()->count();

        $this->selectedFile = ($multiple && ! $selectedFile) ? [] : $selectedFile;

        $this->uploadMode = false;
    }

    private function applyAllowedType($allMedia)
    {
        if (! $this->allowedType) {
            return $allMedia;
        }

        return $allMedia->where(function($query) {
            foreach ($this->allowedType as $type) {
                $query->where('type', 'LIKE', "{$type}%");
            }
        });
    }

    public function render()
    {
        $allMedia = Media::with('owner')->type($this->typeFilter)->search($this->search);
        $allMedia = $this->applyAllowedType($allMedia);
        $allMedia = $allMedia->latest()->paginate(18);

        return view('livewire.admin.utilities.media-listing', compact('allMedia'));
    }

    public function selectFile($id)
    {
        if ($this->multiple) {
            if (in_array($id, $this->selectedFile)) {
                unset($this->selectedFile[ array_search($id, $this->selectedFile) ]);
            } else {
                $this->selectedFile[] = $id;
            }
        } else {
            $this->selectedFile = $id;
        }
    }

    public function setInputValue()
    {
        $this->emitUp('mediaUpdated', $this->selectedFile);
        $this->dispatchBrowserEvent('closeModal', ['id' => 'choose-media-modal-' . $this->inputName]);
    }

    public function updated()
    {
        $this->resetPage();
    }
}
