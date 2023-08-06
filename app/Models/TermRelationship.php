<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermRelationship extends Model
{
    use HasFactory;

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
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
