<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermExtra extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = true;

    public function rules()
    {
        return [
            '_description' => 'nullable',
            '_thumbnail' => 'nullable|exists:media,id',
        ];
    }

    public function categoryRules($for = null)
    {
        $rules = $this->rules();

        if ($for == 'post') {
            $rules += [
                '_meta_key' => 'nullable',
                '_meta_description' => 'nullable'
            ];
        }

        return $rules;
    }

    public function tagRules()
    {
        $rules = $this->rules();
        unset($rules['_thumbnail']);
        return $rules;
    }

    public function attributeRules()
    {
        return [
            '_attribute_values' => 'required'
        ];
    }

    public function colorRules()
    {
        return [
            '_color_code' => 'required'
        ];
    }

    public function sizeRules()
    {
        return [];
    }

    public function brandRules()
    {
        return $this->rules();
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public static function prepareInputFromKeyName($data, $term_id)
    {
        $result = [];

        foreach ($data as $key => $value) {
            $result[] = [
                'term_id' => $term_id,
                'key_name' => $key,
                'key_value' => $value,
            ];
        }

        return $result;
    }

    public function scopeWhereKeyName($query, $key)
    {
        return $query->where('key_name', $key);
    }
}
