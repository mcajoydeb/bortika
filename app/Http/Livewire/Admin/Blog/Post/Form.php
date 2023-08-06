<?php

namespace App\Http\Livewire\Admin\Blog\Post;

use App\Models\Post;
use App\Services\SlugCreationService;
use Livewire\Component;

class Form extends Component
{
    public $post;
    public $post_title;
    public $post_slug;
    public $post_content;
    public $parent_id;
    public $_featured_image;
    public $_seo_page_title;
    public $_seo_page_slug;
    public $_seo_meta_description;
    public $_seo_meta_keywords;
    public $_allowed_max_characters;
    public $_allow_comments = false;
    public $_post_password;
    public $_post_scheduled_start_time;
    public $_post_scheduled_end_time;
    public $_categories = [];
    public $post_status;

    public $listeners = [ 'categoryItemSelected' => 'updateCategories' ];

    public function mount()
    {
        $this->post_status = config('post-status.publish.value');

        if (old('post_title')) {
            $this->initializeData('old');
        } elseif ($this->post) {
            $this->initializeData('post');
        }
    }

    public function initializeData($type)
    {
        $this->post_title                  = ($type == 'old') ? old('post_title') : $this->post->post_title;
        $this->post_slug                   = ($type == 'old') ? old('post_slug') : $this->post->post_slug;
        $this->post_content                = ($type == 'old') ? old('post_content') : $this->post->post_content;
        $this->_featured_image             = ($type == 'old') ? old('_featured_image') : $this->post->getExtraByKeyName('_featured_image');
        $this->_seo_page_title             = ($type == 'old') ? old('_seo_page_title') : $this->post->getExtraByKeyName('_seo_page_title');
        $this->_seo_page_slug              = ($type == 'old') ? old('_seo_page_slug') : $this->post->getExtraByKeyName('_seo_page_slug');
        $this->_seo_meta_description       = ($type == 'old') ? old('_seo_meta_description') : $this->post->getExtraByKeyName('_seo_meta_description');
        $this->_seo_meta_keywords          = ($type == 'old') ? old('_seo_meta_keywords') : $this->post->getExtraByKeyName('_seo_meta_keywords');
        $this->_allowed_max_characters     = ($type == 'old') ? old('_allowed_max_characters') : $this->post->getExtraByKeyName('_allowed_max_characters');
        $this->_allow_comments             = ($type == 'old') ? old('_allow_comments') : $this->post->getExtraByKeyName('_allow_comments');
        $this->_post_scheduled_start_time  = ($type == 'old') ? old('_post_scheduled_start_time') : $this->post->getExtraByKeyName('_post_scheduled_start_time');
        $this->_post_scheduled_end_time    = ($type == 'old') ? old('_post_scheduled_end_time') : $this->post->getExtraByKeyName('_post_scheduled_end_time');
        $this->_categories                 = ($type == 'old') ? old('_categories') : $this->post->getExtraByKeyName('_categories');
        $this->post_status                 = ($type == 'old') ? old('post_status') : $this->post->post_status;
    }

    public function rules()
    {
        $post = new Post;

        if ($this->post) {
            $post = $this->post;
        }

        return $post->rules() + $post->extraRules();
    }

    public function render()
    {
        return view('livewire.admin.blog.post.form');
    }

    public function updatedPostTitle()
    {
        $this->post_slug = SlugCreationService::create(Post::class, 'post_slug', $this->post_title);
    }

    public function updated($attribute)
    {
        if ($attribute == 'post_title') {
            $this->updatedPostTitle();
            $this->_seo_page_title = $this->post_title;
            $this->_seo_page_slug = $this->post_slug;
        }

        $this->validate($this->rules(), [
            '_post_scheduled_start_time.required_if' => 'Required',
            '_post_scheduled_end_time.required_if' => 'Required',
        ]);
    }

    public function updateCategories($selectedCategories)
    {
        $this->_categories = $selectedCategories;
    }
}
