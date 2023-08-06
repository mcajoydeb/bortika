<?php

namespace App\Http\Livewire\Admin\Blog\Category;

use App\Models\Term;
use Livewire\Component;
use App\Models\TermExtra;
use Livewire\WithFileUploads;
use App\Services\SlugCreationService;

class Form extends Component
{
    use WithFileUploads;

    public $term;
    public $name;
    public $slug;
    public $parent_id;
    public $_description;
    public $_meta_key;
    public $_meta_description;
    public $_thumbnail;
    public $status;

    public function mount()
    {
        $this->status = config('general-status-options.active.value');

        if (old('name')) {
            $this->initializeData('old');
        } elseif ($this->term) {
            $this->initializeData('term');
        }
    }

    public function initializeData($type)
    {
        $this->name              = ($type == 'old') ? old('name') : $this->term->name;
        $this->slug              = ($type == 'old') ? old('slug') : $this->term->slug;
        $this->parent_id         = ($type == 'old') ? old('parent_id') : $this->term->parent_id;
        $this->_description      = ($type == 'old') ? old('_description') : $this->term->getExtraValueByKey('_description');
        $this->_meta_key         = ($type == 'old') ? old('_meta_key') : $this->term->getExtraValueByKey('_meta_key');
        $this->_meta_description = ($type == 'old') ? old('_meta_description') : $this->term->getExtraValueByKey('_meta_description');
        $this->_thumbnail        = ($type == 'old') ? old('_thumbnail') : $this->term->getExtraValueByKey('_thumbnail');
        $this->status            = ($type == 'old') ? old('status') : $this->term->status;
    }

    public function rules()
    {
        if ($this->term) {
            $rules = Term::find($this->term->id)->rules();
        } else {
            $rules = (new Term)->rules();
        }

        return $rules + (new TermExtra())->categoryRules('post');
    }

    public function render()
    {
        return view('livewire.admin.blog.category.form');
    }

    public function updatedName()
    {
        $this->slug = SlugCreationService::create(Term::class, 'slug', $this->name);
    }

    public function updated($attribute)
    {
        if ($attribute == 'name') {
            $this->updatedName();
        }

        $this->validate();
    }
}
