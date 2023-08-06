<?php

namespace Database\Seeders;

use App\Models\Term;
use App\Models\Media;
use App\Models\TermExtra;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Term::truncate();
        TermExtra::truncate();

        $_this = $this;

        Term::factory(200)->create()->each(function($term) use ($_this) {
            switch ($term->type) {
                case config('term-types.post_category'):
                    $_this->runPostCategorySeeder($term);
                    break;
                case config('term-types.product_category'):
                    $_this->runProductCategory($term);
                    break;
                case config('term-types.product_tag'):
                    $_this->runProductTag($term);
                    break;
                case config('term-types.product_attribute'):
                    $_this->runProductAttribute($term);
                    break;
                case config('term-types.product_color'):
                    $_this->runProductColor($term);
                    break;
                case config('term-types.product_size'):
                    $_this->runProductSize($term);
                    break;
                case config('term-types.product_brand'):
                    $_this->runProductBrand($term);
                    break;
                default:
                    break;
            }
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function runPostCategorySeeder($term)
    {
        TermExtra::insert([
            ['term_id' => $term->id,'key_name' => '_description', 'key_value' => ''],
            ['term_id' => $term->id,'key_name' => '_thumbnail', 'key_value' => Media::inRandomOrder()->first()->id],
            ['term_id' => $term->id,'key_name' => '_meta_key', 'key_value' => ''],
            ['term_id' => $term->id,'key_name' => '_meta_description', 'key_value' => ''],
        ]);
    }

    public function runProductCategory($term)
    {
        TermExtra::insert([
            ['term_id' => $term->id,'key_name' => '_description', 'key_value' => ''],
            ['term_id' => $term->id,'key_name' => '_thumbnail', 'key_value' => Media::inRandomOrder()->first()->id],
        ]);
    }

    public function runProductTag($term)
    {

    }

    public function runProductAttribute($term)
    {
        TermExtra::insert([
            ['term_id' => $term->id,'key_name' => '_attribute_values', 'key_value' => implode(',', [
                strtoupper(uniqid()), strtoupper(uniqid()), strtoupper(uniqid())
            ])],
        ]);
    }

    public function runProductColor($term)
    {
        TermExtra::insert([
            ['term_id' => $term->id,'key_name' => '_color_code', 'key_value' => '#' . rand(100000, 999999)],
        ]);
    }

    public function runProductSize($term)
    {

    }

    public function runProductBrand($term)
    {
        TermExtra::insert([
            ['term_id' => $term->id,'key_name' => '_description', 'key_value' => ''],
            ['term_id' => $term->id,'key_name' => '_thumbnail', 'key_value' => Media::inRandomOrder()->first()->id],
        ]);
    }

}
