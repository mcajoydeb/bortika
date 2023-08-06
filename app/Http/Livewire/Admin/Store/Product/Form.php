<?php

namespace App\Http\Livewire\Admin\Store\Product;

use App\Models\Product;
use Livewire\Component;
use App\Services\SlugCreationService;

class Form extends Component
{
    /** @var Product */
    public $product;

    // basic details
    public $title;
    public $slug;
    public $content;
    public $_minimum_purchase_qty;

    // thumbnail and gallery
    public $image_id;
    public $_gallery_image_ids = [];

    // tab section
    public $type;

    // general
    public $sku;
    public $regular_price;
    public $sale_price;
    public $price;
    public $_allow_scheduled_price;
    public $_sale_start_datetime;
    public $_sale_end_datetime;

    // inventory
    public $_enable_stock;
    public $stock_qty;
    public $_back_to_order_status;
    public $stock_availability;

    // features
    public $_features;

    // advanced
    public $_recommended_product;
    public $_featured_product;
    public $_latest_product;
    public $_related_product;
    public $_home_page_product;

    // variations
    public $variations = [];

    // seo
    public $_seo_title;
    public $_seo_slug;
    public $_seo_meta_description;
    public $_seo_meta_keywords;

    // review settings
    public $_enable_reviews;
    public $_enable_add_review_to_product_page;
    public $_enable_add_review_to_details_page;

    // status and other extra details
    public $status;
    public $_brand_id;
    public $_categories = [];
    public $_tag_ids = [];
    public $_color_ids = [];
    public $_size_ids = [];

    // active tab
    public $active_tab;

    public $listeners = [ 'variationUpdated' => 'updateVariations', 'categoryItemSelected' => 'updateCategories' ];

    public function mount()
    {
        $this->status = config('general-status-options.active.value');
        $this->type = config('product-types.simple_product.value');
        $this->stock_availability = config('stock-availability-status.in_stock.value');
        $this->_back_to_order_status = config('back-to-order-status.allow_notify_customer.value');
        $this->_minimum_purchase_qty = 1;

        if (old('title')) {
            $this->initializeData('old');
        } elseif ($this->product) {
            $this->initializeData('product');
        }
    }

    public function initializeData($type)
    {
        $this->title                              = ($type == 'old') ? old('title') : $this->product->title;
        $this->slug                               = ($type == 'old') ? old('slug') : $this->product->slug;
        $this->content                            = ($type == 'old') ? old('content') : $this->product->content;
        $this->_minimum_purchase_qty              = ($type == 'old') ? old('_minimum_purchase_qty') : $this->product->getExtraByKeyName('_minimum_purchase_qty');
        $this->image_id                           = ($type == 'old') ? old('image_id') : $this->product->image_id;
        $this->_gallery_image_ids                 = ($type == 'old') ? old('_gallery_image_ids') : $this->product->getExtraByKeyName('_gallery_image_ids');
        $this->type                               = ($type == 'old') ? old('type') : $this->product->type;
        $this->sku                                = ($type == 'old') ? old('sku') : $this->product->sku;
        $this->regular_price                      = ($type == 'old') ? old('regular_price') : $this->product->regular_price;
        $this->sale_price                         = ($type == 'old') ? old('sale_price') : $this->product->sale_price;
        $this->price                              = ($type == 'old') ? old('price') : $this->product->price;
        $this->_allow_scheduled_price             = ($type == 'old') ? old('_allow_scheduled_price') : $this->product->getExtraByKeyName('_allow_scheduled_price');
        $this->_sale_start_datetime               = ($type == 'old') ? old('_sale_start_datetime') : $this->product->getExtraByKeyName('_sale_start_datetime');
        $this->_sale_end_datetime                 = ($type == 'old') ? old('_sale_end_datetime') : $this->product->getExtraByKeyName('_sale_end_datetime');
        $this->_enable_stock                      = ($type == 'old') ? old('_enable_stock') : $this->product->getExtraByKeyName('_enable_stock');
        $this->stock_qty                          = ($type == 'old') ? old('stock_qty') : $this->product->stock_qty;
        $this->_back_to_order_status              = ($type == 'old') ? old('_back_to_order_status') : $this->product->getExtraByKeyName('_back_to_order_status');
        $this->stock_availability                 = ($type == 'old') ? old('stock_availability') : $this->product->stock_availability;
        $this->_features                          = ($type == 'old') ? old('_features') : $this->product->getExtraByKeyName('_features');
        $this->_recommended_product               = ($type == 'old') ? old('_recommended_product') : $this->product->getExtraByKeyName('_recommended_product');
        $this->_featured_product                  = ($type == 'old') ? old('_featured_product') : $this->product->getExtraByKeyName('_featured_product');
        $this->_latest_product                    = ($type == 'old') ? old('_latest_product') : $this->product->getExtraByKeyName('_latest_product');
        $this->_related_product                   = ($type == 'old') ? old('_related_product') : $this->product->getExtraByKeyName('_related_product');
        $this->_home_page_product                 = ($type == 'old') ? old('_home_page_product') : $this->product->getExtraByKeyName('_home_page_product');
        $this->variations                         = ($type == 'old') ? (old('_variations') ? old('_variations') : []) : $this->getExistingVariationData();
        $this->_seo_title                         = ($type == 'old') ? old('_seo_title') : $this->product->getExtraByKeyName('_seo_title');
        $this->_seo_slug                          = ($type == 'old') ? old('_seo_slug') : $this->product->getExtraByKeyName('_seo_slug');
        $this->_seo_meta_description              = ($type == 'old') ? old('_seo_meta_description') : $this->product->getExtraByKeyName('_seo_meta_description');
        $this->_seo_meta_keywords                 = ($type == 'old') ? old('_seo_meta_keywords') : $this->product->getExtraByKeyName('_seo_meta_keywords');
        $this->_enable_reviews                    = ($type == 'old') ? old('_enable_reviews') : $this->product->getExtraByKeyName('_enable_reviews');
        $this->_enable_add_review_to_product_page = ($type == 'old') ? old('_enable_add_review_to_product_page') : $this->product->getExtraByKeyName('_enable_add_review_to_product_page');
        $this->_enable_add_review_to_details_page = ($type == 'old') ? old('_enable_add_review_to_details_page') : $this->product->getExtraByKeyName('_enable_add_review_to_details_page');
        $this->status                             = ($type == 'old') ? old('status') : $this->product->status;
        $this->_brand_id                          = ($type == 'old') ? old('_brand_id') : $this->product->getExtraByKeyName('_brand_id');
        $this->_categories                        = ($type == 'old') ? old('_categories') : $this->product->getExtraByKeyName('_categories');
        $this->_tag_ids                           = ($type == 'old') ? old('_tag_ids') : $this->product->getExtraByKeyName('_tag_ids');
        $this->_color_ids                         = ($type == 'old') ? old('_color_ids') : $this->product->getExtraByKeyName('_color_ids');
        $this->_size_ids                          = ($type == 'old') ? old('_size_ids') : $this->product->getExtraByKeyName('_size_ids');
        $this->active_tab                         = ($type == 'old') ? old('active_tab') : $this->getActiveTab();
    }

    public function rules()
    {
        if ($this->product) {
            return Product::find($this->product->id)->rules($this->type);
        }

        return (new Product)->rules($this->type);
    }

    public function render()
    {
        return view('livewire.admin.store.product.form');
    }

    public function updatedProductTitle()
    {
        $this->slug = SlugCreationService::create(Product::class, 'slug', $this->title);
        $this->_seo_title = $this->title;
        $this->_seo_slug = $this->slug;
    }

    public function updated($attribute)
    {
        if ($attribute == 'title') {
            $this->updatedProductTitle();
        } elseif ($attribute == 'type') {
            $this->active_tab = $this->getActiveTab();
        }

        $this->validate();
    }

    public function getActiveTab()
    {
        switch ($this->type) {
            case config('product-types.simple_product.value'):
                return 'general';
                break;
            case config('product-types.configurable_product.value'):
                return 'features';
                break;
            case config('product-types.customizable_product.value'):
                return 'general';
                break;
            case config('product-types.downloadable_product.value'):
                return 'general';
                break;
            default:
                return 'general';
        }
    }

    public function openVariationModal()
    {
        $this->emit('resetVariationForm');
        $this->dispatchBrowserEvent('openModal', ['id' => 'variation-form']);
    }

    public function updateVariations($variations)
    {
        $this->variations = $variations;
    }

    public function editVariation($sl, $id)
    {
        $this->emit('editVariation', $sl, $id);
    }

    public function removeVariation($sl, $id)
    {
        $this->emit('removeVariation', $sl, $id);
    }

    public function getExistingVariationData()
    {
        $variations = $this->product->variations()->with('extra')->get()->toArray();

        $variationArr = [];

        foreach ($variations as $variation) {
            foreach ($variation['extra'] as $extra) {
                $variation[ $extra['key_name'] ] = getFormattedUnserializedData($extra['key_value']);
            }
            unset($variation['extra']);
            $variationArr[] = $variation;
        }

        return $variationArr;
    }

    public function updateCategories($selectedCategories)
    {
        $this->_categories = $selectedCategories;
    }
}
