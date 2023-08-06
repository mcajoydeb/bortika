<?php

namespace App\Services;

trait HasModelExtra
{
    public function getExtraByKeyName($key_name)
    {
        $data = $this->extra()->where('key_name', $key_name)->first();
        return getFormattedUnserializedData($data->key_value ?? null);
    }
}
