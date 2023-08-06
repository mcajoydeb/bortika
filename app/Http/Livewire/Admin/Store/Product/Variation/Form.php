<?php

namespace App\Http\Livewire\Admin\Store\Product\Variation;

use App\Models\Product;
use Livewire\Component;
use App\Services\SlugCreationService;
use App\Services\ProductRequestFilterService;

class Form extends Component
{
    public $variations = [];
    public $variationEditMode = false;
    public $variationId;
    public $variationKey;
    public $_attributes = [];
    public $variation_title;
    public $variation_slug;
    public $variation_content;
    public $variation_minimum_purchase_qty;
    public $variation_image_id;
    public $variation_sku;
    public $variation_regular_price;
    public $variation_sale_price;
    public $variation_enable_stock;
    public $variation_stock_qty;
    public $variation_back_to_order_status;
    public $variation_stock_availability;
    public $variation_seo_title;
    public $variation_seo_slug;
    public $variation_seo_meta_description;
    public $variation_seo_meta_keywords;
    public $variation_enable_reviews;
    public $variation_enable_add_review_to_product_page;
    public $variation_enable_add_review_to_details_page;
    public $variation_status;

    protected $listeners = [
        'mediaUpdated' => 'updateImageId',
        'editVariation' => 'editVariation',
        'removeVariation' => 'removeVariation',
        'resetVariationForm' => 'resetForm',
    ];

    public function mount($variations = [])
    {
        foreach (\App\Services\ProductAttributeService::getProductAttributes() as $key => $value) {
            $this->_attributes[$key] = null;
        }

        $this->variations = $variations;
        $this->variation_back_to_order_status = config('back-to-order-status.allow_notify_customer.value');
        $this->variation_status = config('general-status-options.active.value');
        $this->variation_stock_availability = config('stock-availability-status.in_stock.value');
    }

    public function render()
    {
        return view('livewire.admin.store.product.variation.form');
    }

    public function rules()
    {
        if ($this->variationId) {
            return (Product::find($this->variationId))->variationRules();
        }

        return (new Product)->variationRules();
    }

    public function addVariation()
    {
        $this->validate();

        $dataArr = [
            '_attributes' => $this->_attributes,
            'id' => $this->variationId,
            'title' => $this->variation_title,
            'slug' => $this->variation_slug,
            'content' => $this->variation_content,
            '_minimum_purchase_qty' => $this->variation_minimum_purchase_qty,
            'image_id' => $this->variation_image_id,
            'sku' => $this->variation_sku,
            'regular_price' => $this->variation_regular_price,
            'sale_price' => $this->variation_sale_price,
            'price' => ProductRequestFilterService::determinePrice($this->variation_regular_price, $this->variation_sale_price),
            '_enable_stock' => $this->variation_enable_stock,
            'stock_qty' => $this->variation_stock_qty,
            '_back_to_order_status' => $this->variation_back_to_order_status,
            'stock_availability' => $this->variation_stock_availability,
            '_seo_title' => $this->variation_seo_title,
            '_seo_slug' => $this->variation_seo_slug,
            '_seo_meta_description' => $this->variation_seo_meta_description,
            '_seo_meta_keywords' => $this->variation_seo_meta_keywords,
            '_enable_reviews' => $this->variation_enable_reviews,
            '_enable_add_review_to_product_page' => $this->variation_enable_add_review_to_product_page,
            '_enable_add_review_to_details_page' => $this->variation_enable_add_review_to_details_page,
            'status' => $this->variation_status,
        ];

        if ($this->variationEditMode) {
            $this->variations[$this->variationKey] = $dataArr;
        } else {
            $this->variations[] = $dataArr;
        }

        $this->variationEditMode = false;

        $this->emit('variationUpdated', $this->variations);

        $this->dispatchBrowserEvent('closeModal', ['id' => 'variation-form']);

        $this->resetForm();
    }

    public function editVariation($variationKey, $variationId)
    {
        $this->variationKey = $variationKey;
        $this->variationId = $variationId;

        $variationArr = $this->variations[$variationKey];
        $this->setValues($variationArr);

        $this->variationEditMode = true;

        $this->dispatchBrowserEvent('openModal', ['id' => 'variation-form']);
    }

    public function removeVariation($variationKey, $variationId)
    {
        $this->variationKey = $variationKey;
        $this->variationId = $variationId;

        $variationArr = [];

        if (empty($variationId)) {
            unset($this->variations[$variationKey]);
        } else {
            $variationArr = $this->variations[$variationKey];
            $variationArr['is_deleted'] = 1;
            $this->variations[$variationKey] = $variationArr;
        }

        $this->emit('variationUpdated', $this->variations);
    }

    public function updateImageId($id)
    {
        $this->variation_image_id = $id;
    }

    public function updatedVariationTitle()
    {
        $this->variation_slug = SlugCreationService::create(Product::class, 'slug', $this->variation_title);
        $this->variation_seo_title = $this->variation_title;
        $this->variation_seo_slug = $this->variation_slug;
    }

    public function updated($attribute)
    {
        if ($attribute == 'variation_title') {
            $this->updatedVariationTitle();
        }

        $this->validate();
    }

    public function setValues($data)
    {
        $this->_attributes = $data['_attributes'] ?? [];
        $this->variationId = $data['id'] ?? null;
        $this->variation_title = $data['title'] ?? null;
        $this->variation_slug = $data['slug'] ?? null;
        $this->variation_content = $data['content'] ?? null;
        $this->variation_minimum_purchase_qty = $data['_minimum_purchase_qty'] ?? null;
        $this->variation_image_id = $data['image_id'] ?? null;
        $this->variation_sku = $data['sku'] ?? null;
        $this->variation_regular_price = $data['regular_price'] ?? null;
        $this->variation_sale_price = $data['sale_price'] ?? null;
        $this->variation_enable_stock = $data['_enable_stock'] ?? null;
        $this->variation_stock_qty = $data['stock_qty'] ?? null;
        $this->variation_back_to_order_status = $data['_back_to_order_status'] ?? config('back-to-order-status.allow_notify_customer.value');
        $this->variation_stock_availability = $data['stock_availability'] ?? config('stock-availability-status.in_stock.value');
        $this->variation_seo_title = $data['_seo_title'] ?? null;
        $this->variation_seo_slug = $data['_seo_slug'] ?? null;
        $this->variation_seo_meta_description = $data['_seo_meta_description'] ?? null;
        $this->variation_seo_meta_keywords = $data['_seo_meta_keywords'] ?? null;
        $this->variation_enable_reviews = $data['_enable_reviews'] ?? null;
        $this->variation_enable_add_review_to_product_page = $data['_enable_add_review_to_product_page'] ?? null;
        $this->variation_enable_add_review_to_details_page = $data['_enable_add_review_to_details_page'] ?? null;
        $this->variation_status = $data['status'] ?? config('general-status-options.active.value');
    }

    public function resetForm()
    {
        // reset everything except variations and ids to be deleted
        $variations = $this->variations;
        $this->reset();
        $this->mount($variations);
        $this->variations = $variations;
    }
}
