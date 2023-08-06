<?php

namespace App\Models;

use App\Services\HasGeneralStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory, HasGeneralStatus;

    protected $guarded = [];

    public $timestamps = true;

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'slug' => 'sometimes|required|max:255|unique:terms,slug,' . $this->id,
            'parent_id' => 'sometimes|nullable|exists:terms,id',
            'status' => 'required|' . $this->generalStatusRule(),
        ];
    }

    public function extra()
    {
        return $this->hasMany(TermExtra::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function objects($type)
    {
        return $this->belongsToMany(
            Product::class,
            TermRelationship::class,
            'term_id',
            'object_id'
        )->wherePivot('object', $type);
    }

    public function posts()
    {
        return $this->objects(config('term-objects.post'));
    }

    public function products()
    {
        return $this->objects(config('term-objects.product'));
    }

    public function parentCategoryName()
    {
        return $this->parent ? $this->parent->name : null;
    }

    public function scopeParentId($query, $parent_id)
    {
        return $query->where('parent_id', $parent_id);
    }

    public function scopeSearch($query, $value)
    {
        if (!empty($value)) {
            return $query->where('terms.name', 'LIKE', "%{$value}%");
        }

        return $query;
    }

    public function scopeWhereType($query, $type)
    {
        return $query->where('terms.type', $type);
    }

    public function scopeProductCategories($query)
    {
        return $query->whereType(config('term-types.product_category'));
    }

    public function scopeTags($query)
    {
        return $query->whereType(config('term-types.product_tag'));
    }

    public function scopeAttributes($query)
    {
        return $query->whereType(config('term-types.product_attribute'));
    }

    public function scopeColors($query)
    {
        return $query->whereType(config('term-types.product_color'));
    }

    public function scopeSizes($query)
    {
        return $query->whereType(config('term-types.product_size'));
    }

    public function scopeBrands($query)
    {
        return $query->whereType(config('term-types.product_brand'));
    }

    public function getCategoryImage($type = 'thumbnail')
    {
        $path = null;

        $extra = $this->extra()->whereKeyName('_thumbnail')->first();

        if ($extra) {
            $attribute = $type == 'thumbnail' ? 'asset_thumbnail_url' : 'asset_url';
            $path = optional(Media::find($extra->key_value))->{$attribute};
        }

        if (! empty($path)) {
            return $path;
        }

        return (new Media)->imagePlaceholder();
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->getCategoryImage();
    }

    public function getCategoryImageUrlAttribute()
    {
        return $this->getCategoryImage('asset_url');
    }

    public function getExtraValueByKey($keyName)
    {
        $extra = $this->extra()->whereKeyName($keyName)->first();
        return optional($extra)->key_value;
    }

    public function scopeActiveAttributes($query)
    {
        return $query->attributes()->active();
    }

    public function scopeActiveBrands($query)
    {
        return $query->brands()->active();
    }

    public function scopeActiveColors($query)
    {
        return $query->colors()->active();
    }

    public function scopeActiveTags($query)
    {
        return $query->tags()->active();
    }

    public function scopeActiveSizes($query)
    {
        return $query->sizes()->active();
    }

    public function scopeActiveProductCategories($query)
    {
        return $query->productCategories()->active();
    }

    public function scopeActivePostCategories($query)
    {
        return $query->postCategories()->active();
    }

    public function getAttributeValues()
    {
        $values = $this
        ->extra()
        ->select('term_extras.key_value')
        ->whereKeyName('_attribute_values')
        ->first()
        ->toArray();

        return explode(',', $values['key_value']);
    }

    public function scopePostCategories($query)
    {
        return $query->whereType(config('term-types.post_category'));
    }

    public function scopeOnlyParent($query)
    {
        return $query->whereNull('parent_id')->orWhere('parent_id', '')->active();
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    public function getProducts($limit)
    {
        $query = $this->products()->active()->latest();

        if ($limit) {
            $query = $query->take(10);
        }

        return $query->get();
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
