<?php

namespace App\Pipelines\Admin\Post;

use Closure;

class AddAuthorAndPostType
{
    public function handle($postData, Closure $next)
    {
        $postData['post_author_id'] = auth()->user()->id;
        $postData['post_type'] = config('post-types.post.value');

        return $next($postData);
    }
}
