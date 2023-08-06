<?php

namespace App\Services;

use App\Models\Term;

class PublicHomeService
{
    public static function getProductParentCategories()
    {
        return Term::activeProductCategories()->onlyParent()->get();
    }

    public static function getPostParentCategories()
    {
        return Term::activePostCategories()->onlyParent()->get();
    }
}
