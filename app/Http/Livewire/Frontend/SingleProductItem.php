<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

class SingleProductItem extends Component
{
    public $product;

    public function render()
    {
        return view('livewire.frontend.single-product-item');
    }
}
