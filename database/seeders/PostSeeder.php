<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Term;
use App\Models\Media;
use App\Models\PostExtra;
use Illuminate\Database\Seeder;
use App\Models\TermRelationship;
use App\Services\TermRelationshipService;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Post::truncate();
        PostExtra::truncate();

        Post::factory(100)->create()->each(function($post) {
            $allowedChar = rand(0, 500);
            $allowedChar = $allowedChar < 200 ? null : $allowedChar;

            $startTime = $post->isScheduledPublish() ? Carbon::now()->addDays(rand(5, 30))->format('Y-m-d') : null;
            $endTime = $startTime ? Carbon::parse($startTime)->addDays(rand(10 ,30))->format('Y-m-d') : null;

            $categories = Term::activePostCategories()->inRandomOrder()->take(rand(2,3))->pluck('id')->toArray();

            TermRelationship::insert( TermRelationshipService::prepareData(
                $categories, $post->id, config('term-objects.post'))
            );

            PostExtra::insert([
                ['post_id' => $post->id, 'key_name' => '_featured_image', 'key_value' => optional(Media::inRandomOrder()->first())->id],
                ['post_id' => $post->id, 'key_name' => '_seo_page_title', 'key_value' => $post->post_title],
                ['post_id' => $post->id, 'key_name' => '_seo_page_slug', 'key_value' => $post->post_slug],
                ['post_id' => $post->id, 'key_name' => '_seo_meta_description', 'key_value' => ''],
                ['post_id' => $post->id, 'key_name' => '_seo_meta_keywords', 'key_value' => ''],
                ['post_id' => $post->id, 'key_name' => '_allowed_max_characters', 'key_value' => $allowedChar],
                ['post_id' => $post->id, 'key_name' => '_allow_comments', 'key_value' => rand(0, 1)],
                ['post_id' => $post->id, 'key_name' => '_post_password', 'key_value' => $post->isPrivate() ? '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' : null], // password
                ['post_id' => $post->id, 'key_name' => '_post_scheduled_start_time', 'key_value' => $startTime],
                ['post_id' => $post->id, 'key_name' => '_post_scheduled_end_time', 'key_value' => $endTime],
                ['post_id' => $post->id, 'key_name' => '_categories', 'key_value' => serialize($categories)],
            ]);
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
