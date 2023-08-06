<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\SelectInputArrayHelperService;
use App\Services\SlugCreationService;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();

        return [
            'post_author_id' => $this->faker->numberBetween(1, User::count()),
            'post_title' => $title,
            'post_slug' => SlugCreationService::create(Post::class, 'post_slug', $title),
            'post_content' => $this->faker->realText(),
            'parent_id' => null,
            'post_status' => config('post-status.publish.value'),
            'post_type' => config('post-types.post.value'),
        ];
    }
}
