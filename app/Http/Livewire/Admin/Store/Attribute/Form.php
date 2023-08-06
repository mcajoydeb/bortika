<?php

namespace App\Http\Livewire\Admin\Store\Attribute;

use App\Models\Term;
use App\Models\TermExtra;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $term;
    public $name;
    public $slug;
    public $parent_id;
    public $_attribute_values;
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
        $this->slug              = null;
        $this->parent_id         = null;
        $this->_attribute_values = ($type == 'old') ? old('_attribute_values') : $this->term->getExtraValueByKey('_attribute_values');
        $this->status            = ($type == 'old') ? old('status') : $this->term->status;
    }

    public function rules()
    {
        if ($this->term) {
            $rules = Term::find($this->term->id)->rules();
        } else {
            $rules = (new Term)->rules();
        }

        unset($rules['slug']);

        return $rules + (new TermExtra())->attributeRules();
    }

    public function render()
    {
        return view('livewire.admin.store.attribute.form');
    }

    public function updated()
    {
        $this->validate();
    }
}
