<?php

namespace App\Models;

use App\Services\HasOwner;
use App\Services\SoftDeleteScope;
use App\Services\HasGeneralStatus;
use App\Services\HasModelExtra;
use App\Services\ProductTabVisibilityService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\ValidationRuleFromConfigArrayService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Product extends Model
{
    use HasFactory, HasGeneralStatus, HasOwner, SoftDeletes, SoftDeleteScope, HasModelExtra;

    protected $guarded = [];

    public function rules($type)
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug,' . $this->id],
            'content' => ['nullable'],
            'type' => ['required', $this->productTypeRule()],
            '_minimum_purchase_qty' => ['numeric', 'min:1'],
            'image_id' => ['nullable', 'exists:media,id'],
            '_gallery_image_ids' => ['nullable', 'array'],
            '_gallery_image_ids.*' => ['exists:media,id'],
            '_seo_title' => ['nullable', 'string', 'max:255'],
            '_seo_slug' => ['nullable', 'string', 'max:255'],
            '_seo_meta_description' => ['nullable'],
            '_seo_meta_keywords' => ['nullable'],
            '_enable_reviews' => ['sometimes'],
            '_enable_add_review_to_product_page' => ['sometimes'],
            '_enable_add_review_to_details_page' => ['sometimes'],
            'status' => ['required', $this->generalStatusRule()],
            '_brand_id' => ['nullable', 'exists:terms,id'],
            '_categories' => ['nullable', 'array'],
            '_categories.*' => ['exists:terms,id'],
            '_tag_ids' => ['nullable', 'array'],
            '_tag_ids.*' => ['exists:terms,id'],
            '_color_ids' => ['nullable', 'array'],
            '_color_ids.*' => ['exists:terms,id'],
            '_size_ids' => ['nullable', 'array'],
            '_size_ids.*' => ['exists:terms,id'],
        ];

        if (ProductTabVisibilityService::showGeneral($type)) {
            $rules += $this->generalTabRules();
        }

        if (ProductTabVisibilityService::showInventory($type)) {
            $rules += $this->inventoryTabRules();
        }

        if (ProductTabVisibilityService::showFeature($type)) {
            $rules += $this->featureTabRules();
        }

        if (ProductTabVisibilityService::showAdvance($type)) {
            $rules += $this->advancedTabRules();
        }

        if (ProductTabVisibilityService::showVariations($type)) {
            $rules += $this->variationTabRules();
        }

        return $rules;
    }

    public function generalTabRules()
    {
        return [
            'sku' => ['nullable', 'unique:products,sku,' . $this->id, 'max:255'],
            'regular_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            '_allow_scheduled_price' => ['sometimes'],
            '_sale_start_datetime' => ['required_with:_allow_scheduled_price'],
            '_sale_end_datetime' => ['required_with:_allow_scheduled_price'],
        ];
    }

    public function inventoryTabRules()
    {
        return [
            '_enable_stock' => ['sometimes'],
            'stock_qty' => ['required_with:_enable_stock', 'nullable', 'numeric', 'min:0'],
            '_back_to_order_status' => ['required_with:_enable_stock', $this->backToOrderStatusRule()],
            'stock_availability' => ['required', $this->stockAvlRule()],
        ];
    }

    public function featureTabRules()
    {
        return [
            '_features' => ['nullable'],
        ];
    }

    public function advancedTabRules()
    {
        return [
            '_recommended_product' => ['sometimes'],
            '_featured_product' => ['sometimes'],
            '_latest_product' => ['sometimes'],
            '_related_product' => ['sometimes'],
            '_home_page_product' => ['sometimes'],
        ];
    }

    public function variationTabRules()
    {
        return [];
    }

    public function variationRules()
    {
        return [
            'variation_title' => ['required', 'string', 'max:255'],
            'variation_slug' => ['required', 'string', 'max:255', 'unique:products,slug,' . $this->id],
            'variation_content' => ['nullable'],
            'variation_minimum_purchase_qty' => ['numeric', 'min:1'],
            'variation_image_id' => ['nullable', 'exists:media,id'],
            'variation_sku' => ['nullable', 'unique:products,sku,' . $this->id, 'max:255'],
            'variation_regular_price' => ['required', 'numeric', 'min:0'],
            'variation_sale_price' => ['nullable', 'numeric', 'min:0'],
            'variation_enable_stock' => ['sometimes'],
            'variation_stock_qty' => ['required_with:_enable_stock', 'nullable', 'numeric', 'min:0'],
            'variation_back_to_order_status' => ['required_with:_enable_stock', $this->backToOrderStatusRule()],
            'variation_stock_availability' => ['required', $this->stockAvlRule()],
            'variation_seo_title' => ['nullable', 'string', 'max:255'],
            'variation_seo_slug' => ['nullable', 'string', 'max:255'],
            'variation_seo_meta_description' => ['nullable'],
            'variation_seo_meta_keywords' => ['nullable'],
            'variation_enable_reviews' => ['sometimes'],
            'variation_enable_add_review_to_product_page' =>  ['sometimes'],
            'variation_enable_add_review_to_details_page' =>  ['sometimes'],
            'variation_status' => ['required', $this->generalStatusRule()],
        ];
    }

    public function stockAvlRule()
    {
        return ValidationRuleFromConfigArrayService::createRule(config('stock-availability-status'));
    }

    public function productTypeRule()
    {
        return ValidationRuleFromConfigArrayService::createRule(config('product-types'));
    }

    public function backToOrderStatusRule()
    {
        return ValidationRuleFromConfigArrayService::createRule(config('back-to-order-status'));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function extra()
    {
        return $this->hasMany(ProductExtra::class);
    }

    public function terms()
    {
        return $this->belongsToMany(
            Term::class,
            TermRelationship::class,
            'object_id',
            'term_id',
        )->wherePivot('object', config('term-objects.product'));
    }

    public function scopeSearch($query, $value)
    {
        if (!empty($value)) {
            return $query->where('title', 'LIKE', "%{$value}%");
        }

        return $query;
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id');
    }

    public function getTypeLabelAttribute()
    {
        return config('product-types.' . $this->type . '.label');
    }

    public function getFormattedPriceAttribute()
    {
        return config('currency.symbol') . number_format($this->price, 2);
    }

    public function getFormattedRegularPriceAttribute()
    {
        return config('currency.symbol') . number_format($this->regular_price, 2);
    }

    public function variations()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function scopeExcludeVariations($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->image()->exists()) {
            return $this->image->asset_thumbnail_url;
        }

        return (new Media)->imagePlaceholder();
    }

    public function isOnSale()
    {
        $salePrice = $this->getExtraByKeyName('sale_price');
        $allowScheduledPrice = (bool)$this->getExtraByKeyName('_allow_scheduled_price');

        $saleStart = null;
        $saleEnd = null;

        if ($allowScheduledPrice) {
            $saleStart = $this->getExtraByKeyName('_sale_start_datetime');
            $saleEnd = $this->getExtraByKeyName('_sale_end_datetime');

            $saleStart = !empty($saleStart) ? Carbon::parse($saleStart) : null;
            $saleEnd = !empty($saleEnd) ? Carbon::parse($saleEnd) : null;
        }

        if (empty($salePrice)) {
            return false;
        }

        if (!empty($saleStart) && $saleStart->gt(Carbon::now())) {
            return false;
        }

        if (!empty($saleEnd) && $saleEnd->lt(Carbon::now())) {
            return false;
        }

        return true;
    }

    public function scopeFilterTerms($query, $termIds)
    {
        if (empty($termIds)) {
            return $query;
        }

        return $query->join('term_relationships', function ($query) use ($termIds) {
            $query->on('term_relationships.object_id', 'products.id');
            $query->whereIn('term_relationships.term_id', $termIds);
            $query->where('term_relationships.object', config('term-objects.product'));
        })
            ->active()
            ->select('products.*');
    }

    public function isSimple()
    {
        return $this->type == config('product-types.simple_product.value');
    }

    public function isCustomizable()
    {
        return $this->type == config('product-types.customizable_product.value');
    }

    public function scopeSortBy($query, $sortBy)
    {
        switch ($sortBy) {
            case config('product-sorting-options.default.value'):
                $query = $query->orderBy('id', 'DESC');
                break;
            case config('product-sorting-options.price_low_high.value'):
                $query = $query->orderBy('price', 'ASC');
                break;
            case config('product-sorting-options.price_high_low.value'):
                $query = $query->orderBy('price', 'DESC');
                break;
            default:
                $query = $query->orderBy('id', 'DESC');
        }

        return $query;
    }

    public function scopeWhereSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function getGalleryImagesAttribute()
    {
        $galleryImageIds = $this->getExtraByKeyName('_gallery_image_ids');

        if (!empty($galleryImageIds) && is_array($galleryImageIds)) {
            return Media::whereIn('id', $galleryImageIds)->get();
        }

        return (new Collection());
    }

    public function getCategoriesAsString()
    {
        $terms = $this->terms()->activeProductCategories()->select('terms.name as name')->get()->toArray();

        if (!empty($terms)) {
            return implode(', ', array_map(function ($data) {
                return $data['name'];
            }, $terms));
        }

        return null;
    }

    public function getTagsAsString()
    {
        $terms = $this->terms()->activeTags()->select('terms.name as name')->get()->toArray();

        if (!empty($terms)) {
            return implode(', ', array_map(function ($data) {
                return $data['name'];
            }, $terms));
        }

        return null;
    }

    public function colors()
    {
        return $this->terms()->activeColors()->get();
    }

    public function hasColors()
    {
        return $this->terms()->activeColors()->exists();
    }

    public function sizes()
    {
        return $this->terms()->activeSizes()->get();
    }

    public function hasSizes()
    {
        return $this->terms()->activeSizes()->exists();
    }
}
