<?php

namespace App\Services;

use App\Models\Term;
use Illuminate\Support\Collection;

class CategoryTreeNodeService
{
    /** @var Term */
    public $category;

    /** @var Collection */
    public $children;

    /** @var bool */
    public $isSelected;

    /** @var bool */
    public $isCollapsed;

    /** @var array */
    public $selectedItems;

    public function __construct(Term $category, array $selectedItems)
    {
        $this->category = $category;

        $this->children = [];

        $this->selectedItems = $selectedItems;

        $this->isSelected = in_array($category->id, $this->selectedItems) ? true : false;

        foreach ($category->children()->active()->get() as $child) {
            $this->children[] = new self($child, $this->selectedItems);
        }

        $this->isCollapsed = $this->hasAnyChildrenInSelectedItems();
    }

    public function hasAnyChildrenInSelectedItems()
    {
        $flag = false;

        foreach ($this->children as $child) {
            if (in_array($child->category->id, $this->selectedItems)) {
                $flag = true;
                break;
            }
        }

        return $flag;
    }
}
