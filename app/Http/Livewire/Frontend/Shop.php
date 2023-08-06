<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Term;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Shop extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    /** @var string */
    public $sorting;

    /** @var int[] */
    public $selectedCategories = [];

    /** @var int[] */
    public $selectedTerms = [];

    /** @var array */
    protected $listeners = ['categoryItemSelected' => 'updateCategoriesSelected'];

    public function mount()
    {
        $this->sorting = config('product-sorting-options.default.value');
    }

    public function render()
    {
        $brands = Term::activeBrands()->orderBy('name')->get();
        $colors = Term::activeColors()->orderBy('name')->get();
        $sizes = Term::activeSizes()->orderBy('name')->get();
        $tags = Term::activeTags()->orderBy('name')->get();

        $products = Product::filterTerms($this->termsToFilter())->sortBy($this->sorting)->paginate(18);

        return view('livewire.frontend.shop')->with([
            'brands' => $brands,
            'colors' => $colors,
            'sizes' => $sizes,
            'tags' => $tags,
            'products' => $products
        ]);
    }

    public function updateCategoriesSelected($selectedCategories)
    {
        $this->selectedCategories = $selectedCategories;
    }

    public function toggleTerms($termId)
    {
        if (! in_array($termId, $this->selectedTerms)) {
            array_push($this->selectedTerms, $termId);
        } else {
            $this->selectedTerms = array_filter($this->selectedTerms, function($data) use ($termId) {
                if ($termId == $data) {
                    return false;
                }

                return true;
            });
        }
    }

    public function termsToFilter()
    {
        return array_merge($this->selectedTerms, $this->selectedCategories);
    }
}
