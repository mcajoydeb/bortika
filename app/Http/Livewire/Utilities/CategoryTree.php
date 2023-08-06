<?php

namespace App\Http\Livewire\Utilities;

use Livewire\Component;

class CategoryTree extends Component
{
    /** @var string */
    public $type;

    /** @var int */
    public $parentId;

    /** @var array */
    public $selectedItems = [];

    public function mount(string $type, int $parentId, array $selectedItems)
    {
        $this->type = $type;
        $this->parentId = $parentId;
        $this->selectedItems = $selectedItems;
    }

    public function render()
    {
        return view('livewire.utilities.category-tree');
    }

    public function updateSelectedCategories()
    {
        $this->emit('categoryItemSelected', $this->selectedItems);
    }
}
