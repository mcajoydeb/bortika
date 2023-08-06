<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostExtra extends Model
{
    use HasFactory;

    public static $featured_image_folder = 'public/uploads/posts/featured_images';

    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public static function prepareInputFromKeyName($data, $post_id)
    {
        $result = [];

        foreach ($data as $key => $value) {
            $result[] = [
                'post_id' => $post_id,
                'key_name' => $key,
                'key_value' => $value,
            ];
        }

        return $result;
    }

    public function scopePostId($query, $post_id)
    {
        return $query->where('post_id', $post_id);
    }

    public function scopeWherePostIdAndKey($query, $post_id, $key)
    {
        return $query->postId($post_id)->where('key_name', $key);
    }

    public function scopeKeysNotIn($query, $keysArr)
    {
        return $query->whereNotIn('key_name', $keysArr);
    }
}
