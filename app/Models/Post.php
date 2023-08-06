<?php

namespace App\Models;

use App\Services\HasModelExtra;
use App\Services\HasOwner;
use App\Services\SoftDeleteScope;
use App\Services\ValidationRuleFromConfigArrayService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasOwner, SoftDeleteScope, HasModelExtra;

    protected $guarded = [];

    public function rules()
    {
        return [
            'post_title' => 'required|max:255',
            'post_slug' => 'required|max:255|unique:posts,post_slug,' . $this->id,
            'post_content' => 'nullable',
            'parent_id' => 'nullable|exists:posts,id',
            'post_status' => 'required|' . $this->postStatusRule(),
        ];
    }

    public function extraRules()
    {
        return [
            '_featured_image' => 'nullable|exists:media,id',
            '_seo_page_title' => 'nullable|max:255',
            '_seo_page_slug' => 'nullable|max:255',
            '_seo_meta_description' => 'nullable',
            '_seo_meta_keywords' => 'nullable',
            '_allowed_max_characters' => 'nullable|numeric|min:0',
            '_allow_comments' => 'sometimes',
            '_post_password' => 'required_if:post_status,' . config('post-status.private.value'),
            '_post_scheduled_start_time' => 'required_if:post_status,' . config('post-status.scheduled_publish.value'),
            '_post_scheduled_end_time' => 'required_if:post_status,' . config('post-status.scheduled_publish.value'),
            '_categories' => ['nullable', 'array'],
            '_categories.*' => ['exists:terms,id']
        ];
    }

    public function postStatusRule()
    {
        return ValidationRuleFromConfigArrayService::createRule(config('post-status'));
    }

    public function postTypeRule()
    {
        return ValidationRuleFromConfigArrayService::createRule(config('post-type'));
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'post_author_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function parentPostTitle()
    {
        return $this->parent ? $this->parent->post_title : null;
    }

    public function scopeStatus($query, $value)
    {
        if (!empty($value)) {
            return $query->where('post_status', $value);
        }
    }

    public function scopePublish($query)
    {
        return $query->status('publish');
    }

    public function scopePrivate($query)
    {
        return $query->status('private');
    }

    public function scopeDraft($query)
    {
        return $query->status('draft');
    }

    public function scopeScheduledPublish($query)
    {
        return $query->status('scheduled_publish');
    }

    public function isPublish()
    {
        return $this->post_status == 'publish';
    }

    public function isPrivate()
    {
        return $this->post_status == 'private';
    }

    public function isDraft()
    {
        return $this->post_status == 'draft';
    }

    public function isScheduledPublish()
    {
        return $this->post_status == 'scheduled_publish';
    }

    public function extra()
    {
        return $this->hasMany(PostExtra::class);
    }

    public function setPostTitleAttribute($value)
    {
        $this->attributes['post_title'] = Str::title($value);
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image_model) {
            return $this->featured_image_model->asset_url;
        }

        return (new Media)->imagePlaceholder();
    }

    public function getFeaturedImageThumbnailUrlAttribute()
    {
        if ($this->featured_image_model) {
            return $this->featured_image_model->asset_thumbnail_url;
        }

        return (new Media)->imagePlaceholder();
    }

    public function statusLabel()
    {
        $status = config('post-status.' . $this->post_status . '.label');
        $title = '';

        if ($this->isPublish()) {
            $class = 'badge-success';
        } elseif ($this->isPrivate()) {
            $class = 'bg-lightblue';
        } elseif ($this->isDraft()) {
            $class = 'bg-gray-dark';
        } elseif ($this->isScheduledPublish()) {
            $dateString = $this->getScheduledPublishDatesAsString();
            $class = 'badge-primary';
            $title = 'title="'. $dateString .'"';
        } else {
            $class = 'badge-secondary';
        }

        return '<span '. $title .' class="badge '. $class .'">'. $status .'</span>';
    }

    public function getCategoryNamesAttribute()
    {
        $categories = $this->getExtraByKeyName('_categories');

        if (! empty($categories)) {
            $nameArr = Term::whereIn('id', $categories)->pluck('name')->toArray();
            return implode(', ', $nameArr);
        }

        return null;
    }

    public function scopeSearch($query, $value)
    {
        if (!empty($value)) {
            return $query->where('post_title', 'LIKE', "%{$value}%");
        }

        return $query;
    }

    public function scopeSlug($query, $slug)
    {
        return $query->where('post_slug', $slug);
    }

    public function getFeaturedImageModelAttribute()
    {
        return Media::find($this->getExtraByKeyName('_featured_image'));
    }

    public function getScheduledPublishDatesAsString()
    {
        $string = '';

        if ($this->isScheduledPublish()) {
            $startDate = $this->getExtraByKeyName('_post_scheduled_start_time');
            $endDate = $this->getExtraByKeyName('_post_scheduled_end_time');

            $string .= $startDate ? Carbon::parse($startDate)->format('d.m.Y') : '';
            $string .= $endDate ? ' - ' . Carbon::parse($endDate)->format('d.m.Y') : '';
        }

        return $string;
    }

    public function formattedCreatedAt($format = 'M d, Y')
    {
        return $this->created_at->format($format);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id')->where('comments.object', config('term-objects.post'));
    }

    public function scopeTermIds($query, array $termIds)
    {
        return $query->when(count($termIds), function ($query) use ($termIds) {
            $query->join('term_relationships as tr', function($query) use ($termIds) {
                $query->on('tr.object_id', '=', 'posts.id');
                $query->where('tr.object', config('term-objects.post'));
                $query->whereIn('tr.term_id', $termIds);
            });
        });

    }
}
