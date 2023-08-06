<?php

namespace App\Services;

class ValidationRuleFromConfigArrayService
{
    public static function createRule($configArray)
    {
        return 'in:' . implode(',', array_keys($configArray));
    }
}
