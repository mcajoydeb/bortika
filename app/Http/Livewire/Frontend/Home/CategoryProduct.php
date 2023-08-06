<?php

namespace App\Http\Livewire\Frontend\Home;

use App\Models\Term;
use Livewire\Component;

class CategoryProduct extends Component
{
    public $productCategories;
    public $activeCategory;

    public function render()
    {
        $activeCategoryProducts = $this->activeCategory->getProducts(10);

        return view('livewire.frontend.home.category-product', compact('activeCategoryProducts'));
    }

    public function setActiveCategory($categoryId)
    {
        $this->activeCategory = Term::find($categoryId);
        $this->dispatchBrowserEvent('reloadProductSlider');
    }
}
