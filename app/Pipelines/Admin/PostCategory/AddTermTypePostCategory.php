<?php

namespace App\Pipelines\Admin\PostCategory;

use Closure;

class AddTermTypePostCategory
{
    public function handle($postCategory, Closure $next)
    {
        $postCategory['type'] = config('term-types.post_category');
        
        return $next($postCategory);
    }
}
