<?php

namespace App\Services;

trait SoftDeleteScope
{
    public function scopeTrash($query, $showOnlyTrashed = false)
    {
        if ($showOnlyTrashed) {
            return $query->onlyTrashed();
        }

        return $query;
    }
}
