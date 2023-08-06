<?php

namespace App\Services;

use Illuminate\Support\Str;

class ProductRequestFilterService
{
    use FilterModelAndExtraDataFromRequest;

    public static function getDataForProductTable(array $validatedData)
    {
        $result = self::filterMainTableData($validatedData);
        $result['user_id'] = auth()->id();
        $result['price'] = self::determinePrice($result['regular_price'] ?? null, $result['sale_price'] ?? null);
        return $result;
    }

    public static function determinePrice($regularPrice, $salePrice)
    {
        if (empty($salePrice) || is_null($salePrice)) {
            return $regularPrice;
        }

        return $salePrice;
    }
}
