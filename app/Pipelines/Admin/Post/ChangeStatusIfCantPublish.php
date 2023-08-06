<?php

namespace App\Pipelines\Admin\Post;

use Closure;

class ChangeStatusIfCantPublish
{
    public function handle($postData, Closure $next)
    {
        if (! auth()->user()->can('post_publish')) {
            $postData['post_status'] = config('post-status.draft.value');
        }

        return $next($postData);
    }
}
