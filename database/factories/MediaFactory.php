<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'file_name' => $this->faker->word,
            'path' => 'https://picsum.photos/1024/1024?random=' . rand(1000, 9999), //$this->faker->imageUrl(),
            'thumbnail_path' => 'https://picsum.photos/512/512?random=' . rand(1000, 9999), //$this->faker->imageUrl(100, 100),
            'type' => 'image/jpg',
            'added_by' => $this->faker->numberBetween(1, User::count())
        ];
    }
}
