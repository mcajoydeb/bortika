<?php

namespace App\Services;

use App\Models\Term;

class SelectInputArrayHelperService
{
    public static function getFormattedArrayForSelectInput($array)
    {
        return array_map(function ($value) {
            return $value['label'];
        }, $array);
    }
    public static function getGeneralStatusArray()
    {
        return self::getFormattedArrayForSelectInput(config('general-status-options'));
    }

    public static function getPostStatusArray()
    {
        return self::getFormattedArrayForSelectInput(config('post-status'));
    }

    public static function getProductTypeArray()
    {
        // disable configurable and downloadable product types for now
        $productTypes = config('product-types');
        unset($productTypes['configurable_product']);
        unset($productTypes['downloadable_product']);
        return self::getFormattedArrayForSelectInput($productTypes);
    }

    public static function getBackToOrderStatus()
    {
        return self::getFormattedArrayForSelectInput(config('back-to-order-status'));
    }

    public static function getStockAvailabilityStatus()
    {
        return self::getFormattedArrayForSelectInput(config('stock-availability-status'));
    }

    public static function getBrandsList()
    {
        return ['' => 'Select Option'] +
            Term::activeBrands()
                ->get()
                ->pluck('name', 'id')
                ->toArray();
    }

    public static function getColorsList()
    {
        return ['' => 'Select Option'] +
            Term::activeColors()
                ->get()
                ->pluck('name', 'id')
                ->toArray();
    }

    public static function getTagsList()
    {
        return ['' => 'Select Option'] +
            Term::activeTags()
                ->get()
                ->pluck('name', 'id')
                ->toArray();
    }

    public static function getSizesList()
    {
        return ['' => 'Select Option'] +
            Term::activeSizes()
                ->get()
                ->pluck('name', 'id')
                ->toArray();
    }
}
