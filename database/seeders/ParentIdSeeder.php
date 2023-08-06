<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Product;
use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Term::all()->each(function($term) {
            $randNumber = rand(-10, 5);
            $term->parent_id = $randNumber > 0 ? Term::query()
                ->whereType($term->type)
                ->where('id', '<>', $term->id)
                ->active()
                ->inRandomOrder()
                ->first()->id : null;
            $term->save();
        });

        Post::all()->each(function($post) {
            $randNumber = rand(-10, 5);
            $post->parent_id = $randNumber > 0 ? Post::where('id', '<>', $post->id)->inRandomOrder()->first()->id : null;
            $post->save();
        });

        Product::all()->each(function($product) {
            if ($product->isSimple()) {
                return;
            }

            $randNumber = rand(-10, 5);
            $product->parent_id = $randNumber > 0 ? Product::where('id', '<>', $product->id)->inRandomOrder()->first()->id : null;
            $product->save();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
