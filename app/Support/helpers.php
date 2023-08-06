<?php

if (! function_exists('debugForLocalEnv')) {
    function debugForLocalEnv(...$dataList)
    {
        if (config('app.env') != 'local') {
            return;
        }

        dd($dataList);
    }
}

if (! function_exists('getFormattedUnserializedData')) {
    function getFormattedUnserializedData($data)
    {
        try {
            $value = !empty($data) ? unserialize($data) : null;
        } catch (\Exception $e) {
            $value = !empty($data) ? $data : null;
        }

        return $value;
    }
}
