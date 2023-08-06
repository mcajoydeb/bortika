<?php

namespace App\Observers;

use App\Models\PostExtra;
use Carbon\Carbon;

class PostExtraObserver
{
    /**
     * Handle the PostExtra "created" event.
     *
     * @param  \App\Models\PostExtra  $postExtra
     * @return void
     */
    public function created(PostExtra $postExtra)
    {
        //
    }

    /**
     * Handle the PostExtra "creating" event.
     *
     * @param  \App\Models\PostExtra  $postExtra
     * @return void
     */
    public function creating(PostExtra $postExtra)
    {
        if (is_file($postExtra->key_value) && $postExtra->key_name == '_featured_image') {
            $file_path = $postExtra->key_value->store(PostExtra::$featured_image_folder);
            $postExtra->key_value = $file_path;
        }

        $postExtra->created_at = Carbon::now();
        $postExtra->updated_at = Carbon::now();
    }

    /**
     * Handle the PostExtra "updated" event.
     *
     * @param  \App\Models\PostExtra  $postExtra
     * @return void
     */
    public function updated(PostExtra $postExtra)
    {
        $postExtra->updated_at = Carbon::now();
    }

    /**
     * Handle the PostExtra "updating" event.
     *
     * @param  \App\Models\PostExtra  $postExtra
     * @return void
     */
    public function updating(PostExtra $postExtra)
    {
        if (is_file($postExtra->key_value) && $postExtra->key_name == '_featured_image') {
            $prev_image = (PostExtra::withTrashed()->find($postExtra->id))->key_value;

            $file_path = $postExtra->key_value->store(PostExtra::$featured_image_folder);
            $postExtra->key_value = $file_path;

            if ($prev_image)
                unlink($prev_image);
        }
    }

    /**
     * Handle the PostExtra "saving" event.
     *
     * @param  \App\Models\PostExtra  $postExtra
     * @return void
     */
    public function saving(PostExtra $postExtra)
    {
        if (! $postExtra->id && $postExtra->key_name != '_featured_image')
            return;

        $prev_image = (PostExtra::withTrashed()->find($postExtra->id))->key_value;

        if (request()->delete_featured_image) {
            $postExtra->key_value = null;

            if ($prev_image)
                unlink($prev_image);
        }
    }

    /**
     * Handle the PostExtra "deleted" event.
     *
     * @param  \App\Models\PostExtra  $postExtra
     * @return void
     */
    public function deleted(PostExtra $postExtra)
    {
        //
    }

    /**
     * Handle the PostExtra "restored" event.
     *
     * @param  \App\Models\PostExtra  $postExtra
     * @return void
     */
    public function restored(PostExtra $postExtra)
    {
        //
    }

    /**
     * Handle the PostExtra "force deleted" event.
     *
     * @param  \App\Models\PostExtra  $postExtra
     * @return void
     */
    public function forceDeleted(PostExtra $postExtra)
    {
        if ($postExtra->key_name == '_featured_image') {
            $prev_image = $postExtra->key_value;

            if ($prev_image)
                unlink($prev_image);
        }
    }
}
