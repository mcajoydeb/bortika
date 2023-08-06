<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $regularPrice = $this->faker->numberBetween(1000, 10000);
        $amountToSub = $this->faker->numberBetween(-500, 500);
        $salePrice = $amountToSub < 0 ? null : ($regularPrice - $amountToSub);
        $price = $salePrice ? $salePrice : $regularPrice;

        return [
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'parent_id' => null,
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug() . uniqid(),
            'content' => $this->faker->text(),
            'sku' => strtoupper($this->faker->word),
            'regular_price' => $regularPrice,
            'sale_price' => $salePrice,
            'price' => $price,
            'stock_qty' => $this->faker->numberBetween(100, 500),
            'stock_availability' => array_rand(config('stock-availability-status')),
            'status' => array_rand(config('general-status-options')),
            'type' => array_rand(config('product-types')),
            'image_id' => optional(Media::inRandomOrder()->first())->id,
        ];
    }
}
