<?php

namespace App\Services;

use App\Models\Term;

class ProductAttributeService
{
    public static function getProductAttributes()
    {
        $attributes = Term::activeAttributes()->get();

        $array = [];

        foreach ($attributes as $attribute) {

            $attribute_values = $attribute->getAttributeValues();

            $optionKeyValuePair = [];

            foreach ($attribute_values as $value) {
                $value = trim($value);
                $optionKeyValuePair[$attribute->id . ':' . $value] = $value;
            }

            $array[] = [
                'attribute' => $attribute,
                'values' => $optionKeyValuePair,
            ];

        }

        return $array;
    }
}
