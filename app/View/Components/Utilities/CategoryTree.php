<?php

namespace App\View\Components\Utilities;

use App\Models\Term;
use Illuminate\View\Component;
use App\Services\CategoryTreeNodeService;

class CategoryTree extends Component
{

    /** @var string */
    public $type;

    /** @var int */
    public $parentId;

    /** @var array */
    public $selectedItems = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $type, int $parentId, array $selectedItems)
    {
        $this->type = $type;
        $this->parentId = $parentId;
        $this->selectedItems = $selectedItems;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $parentCategories = Term::query()
            ->whereType($this->type)
            ->parentId($this->parentId ? $this->parentId : null)
            ->orderBy('name')
            ->get();

        $categoryNodes = [];

        foreach ($parentCategories as $category) {
            $categoryNodes[] = new CategoryTreeNodeService($category, $this->selectedItems);
        }

        return view('components.utilities.category-tree', compact('categoryNodes'));
    }
}
