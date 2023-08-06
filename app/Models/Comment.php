<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function object()
    {
        if ($this->object == config('term-objects.post')) {
            return $this->belongsTo(Post::class, 'object_id');
        } elseif ($this->object == config('term-objects.product')) {
            return $this->belongsTo(Product::class, 'object_id');
        }

        return null;
    }
}
