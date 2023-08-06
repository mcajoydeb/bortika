<?php

namespace App\Services;

use Illuminate\Support\Str;

trait FilterModelAndExtraDataFromRequest
{
    public static function filterMainTableData(array $validatedData)
    {
        $result = [];

        foreach ($validatedData as $key => $value) {
            if ( ! Str::startsWith($key, '_') ) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public static function filterExtraTableData(array $validatedData, $modelId, $foreignKey)
    {
        $result = [];

        foreach ($validatedData as $key => $value) {
            $value = is_array($value) ? serialize($value) : trim($value);

            if (Str::startsWith($key, '_') && !empty($value)) {
                $result[] = [
                    $foreignKey => $modelId,
                    'key_name' => $key,
                    'key_value' => $value
                ];
            }
        }

        return $result;
    }
}
