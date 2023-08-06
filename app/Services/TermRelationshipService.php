<?php

namespace App\Services;

use App\Models\TermRelationship;

class TermRelationshipService
{
    public static function prepareData($termIds, $objectId, $object)
    {
        $data = [];

        foreach ($termIds as $termId) {
            $data[] = [
                'term_id' => $termId,
                'object_id' => $objectId,
                'object' => $object,
            ];
        }

        return $data;
    }

    public static function prepareAttributeIds(array $attributeArr)
    {
        $attributeIds = [];

        foreach ($attributeArr as $attr) {
            if (empty($attr))
                continue;

            $attrArr = explode(':', $attr);
            $attributeIds[] = $attrArr[0];
        }

        return $attributeIds;
    }

    public static function updateTerms($termIds, $objectId, $object)
    {
        $prevTermIds = TermRelationship::where('object_id',  $objectId)->where('object', $object)->select('term_id')->get()->toArray();

        $prevTermIds = array_map(function ($value) {
            return $value['term_id'];
        }, $prevTermIds);

        $newTermIds = array_diff($termIds, $prevTermIds);

        TermRelationship::insert( self::prepareData($newTermIds, $objectId, $object) );
        TermRelationship::whereNotIn('term_id', $termIds)->where('object_id', $objectId)->where('object', $object)->delete();
    }

    public static function getTermIdsForProduct(array $validatedData)
    {
        $termIds = isset($validatedData['_brand_id']) ? [$validatedData['_brand_id']] : [];
        $termIds += $validatedData['_categories'] ?? [];
        $termIds += $validatedData['_tag_ids'] ?? [];
        $termIds += $validatedData['_color_ids'] ?? [];
        $termIds += $validatedData['_size_ids'] ?? [];
        return $termIds;
    }

    public static function getTermIdsForPost(array $validatedData)
    {
        $termIds = $validatedData['_categories'] ?? [];
        return $termIds;
    }
}
