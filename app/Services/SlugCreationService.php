<?php

namespace App\Services;

use Illuminate\Support\Str;

class SlugCreationService
{
    public static function create($modelClass, $slugField, $textFromSlugToBeCreated)
    {
        $model = new $modelClass();

        $slug = Str::slug($textFromSlugToBeCreated);

        while ($count = $model->where($slugField, $slug)->count()) {
            $slug .= '-' . $count;
        }

        return $slug;
    }
}
