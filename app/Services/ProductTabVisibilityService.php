<?php

namespace App\Services;

class ProductTabVisibilityService
{
    public static function showGeneral($productType)
    {
        return in_array($productType, [
            config('product-types.simple_product.value'),
            config('product-types.customizable_product.value'),
            config('product-types.downloadable_product.value')
        ]);
    }

    public static function showInventory($productType)
    {
        return in_array($productType, [
            config('product-types.simple_product.value'),
            config('product-types.customizable_product.value'),
            config('product-types.downloadable_product.value')
        ]);
    }

    public static function showFeature($productType)
    {
        return in_array($productType, [
            config('product-types.simple_product.value'),
            config('product-types.customizable_product.value'),
            config('product-types.configurable_product.value'),
            config('product-types.downloadable_product.value')
        ]);
    }

    public static function showAdvance($productType)
    {
        return in_array($productType, [
            config('product-types.simple_product.value'),
            config('product-types.customizable_product.value'),
            config('product-types.configurable_product.value'),
            config('product-types.downloadable_product.value')
        ]);
    }

    public static function showAttributes($productType)
    {
        return in_array($productType, [
            config('product-types.configurable_product.value'),
            config('product-types.customizable_product.value'),
            config('product-types.downloadable_product.value')
        ]);
    }

    public static function showVariations($productType)
    {
        return in_array($productType, [
            config('product-types.configurable_product.value'),
            config('product-types.customizable_product.value'),
            config('product-types.downloadable_product.value')
        ]);
    }

    public static function showManageDesigns($productType)
    {
        return in_array($productType, [
            config('product-types.customizable_product.value'),
        ]);
    }

    public static function showManageDownloadFiles($productType)
    {
        return in_array($productType, [
            config('product-types.downloadable_product.value'),
        ]);
    }
}
