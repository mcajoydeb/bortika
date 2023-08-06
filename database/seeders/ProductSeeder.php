<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Term;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductExtra;
use Illuminate\Database\Seeder;
use App\Models\TermRelationship;
use App\Services\TermRelationshipService;
use App\Services\ProductTabVisibilityService;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Product::truncate();
        ProductExtra::truncate();

        $_this = $this;

        Product::factory(200)->create()->each(function($product) use ($_this) {
            $minQtyAllowed = rand(-5, 5);
            $minQtyAllowed = $minQtyAllowed <= 0 ? 1 : $minQtyAllowed;

            $galleryIds = Media::inRandomOrder()->take(rand(2, 5))->pluck('id')->toArray();

            $categories = Term::activeProductCategories()->inRandomOrder()->take(rand(2,3))->pluck('id')->toArray();
            $brand = Term::activeBrands()->inRandomOrder()->first()->id;
            $tags = Term::activeTags()->inRandomOrder()->take(rand(2,3))->pluck('id')->toArray();
            $colors = Term::activeColors()->inRandomOrder()->take(rand(2,3))->pluck('id')->toArray();
            $sizes = Term::activeSizes()->inRandomOrder()->take(rand(2,3))->pluck('id')->toArray();

            TermRelationship::insert( TermRelationshipService::prepareData(
                $categories + $tags + $colors + $sizes, $product->id, config('term-objects.product'))
            );

            ProductExtra::insert([
                ['product_id' => $product->id, 'key_name' => '_minimum_purchase_qty', 'key_value' => $minQtyAllowed],
                ['product_id' => $product->id, 'key_name' => '_gallery_image_ids', 'key_value' => serialize($galleryIds)],
                ['product_id' => $product->id, 'key_name' => '_seo_title', 'key_value' => $product->title],
                ['product_id' => $product->id, 'key_name' => '_seo_slug', 'key_value' => $product->slug],
                ['product_id' => $product->id, 'key_name' => '_seo_meta_description', 'key_value' => ''],
                ['product_id' => $product->id, 'key_name' => '_seo_meta_keywords', 'key_value' => ''],
                ['product_id' => $product->id, 'key_name' => '_enable_reviews', 'key_value' => rand(0, 1)],
                ['product_id' => $product->id, 'key_name' => '_enable_add_review_to_product_page', 'key_value' => rand(0, 1)],
                ['product_id' => $product->id, 'key_name' => '_enable_add_review_to_details_page', 'key_value' => rand(0, 1)],
                ['product_id' => $product->id, 'key_name' => '_brand_id', 'key_value' => $brand],
                ['product_id' => $product->id, 'key_name' => '_categories', 'key_value' => serialize($categories)],
                ['product_id' => $product->id, 'key_name' => '_tag_ids', 'key_value' => serialize($tags)],
                ['product_id' => $product->id, 'key_name' => '_color_ids', 'key_value' => serialize($colors)],
                ['product_id' => $product->id, 'key_name' => '_size_ids', 'key_value' => serialize($sizes)],
            ]);

            if (ProductTabVisibilityService::showGeneral($product->type)) {
                $_this->runGeneralSeeder($product);
            }

            if (ProductTabVisibilityService::showInventory($product->type)) {
                $_this->runInventorySeeder($product);
            }

            if (ProductTabVisibilityService::showFeature($product->type)) {
                $_this->runFeatureSeeder($product);
            }

            if (ProductTabVisibilityService::showAdvance($product->type)) {
                $_this->runAdvanceSeeder($product);
            }

            if (!empty($product->parent_id)) {
                $_this->runVariationExtraSeeder($product);
            }
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function runGeneralSeeder($product)
    {
        $allowScheduledPrice = rand(0, 1);
        $startTime = $allowScheduledPrice ? Carbon::now()->addDays(rand(5, 30))->format('Y-m-d') : '';
        $endTime = (bool)$startTime ? Carbon::parse($startTime)->addDays(rand(10 ,30))->format('Y-m-d') : '';

        ProductExtra::insert([
            ['product_id' => $product->id, 'key_name' => '_allow_scheduled_price', 'key_value' => $allowScheduledPrice],
            ['product_id' => $product->id, 'key_name' => '_sale_start_datetime', 'key_value' => $startTime],
            ['product_id' => $product->id, 'key_name' => '_sale_end_datetime', 'key_value' => $endTime],
        ]);
    }

    public function runInventorySeeder($product)
    {
        ProductExtra::insert([
            ['product_id' => $product->id, 'key_name' => '_enable_stock', 'key_value' => rand(0, 1)],
            ['product_id' => $product->id, 'key_name' => '_back_to_order_status', 'key_value' => array_rand(config('back-to-order-status'))],
        ]);
    }

    public function runFeatureSeeder($product)
    {
        ProductExtra::insert([
            ['product_id' => $product->id, 'key_name' => '_features', 'key_value' => ''],
        ]);
    }

    public function runAdvanceSeeder($product)
    {
        ProductExtra::insert([
            ['product_id' => $product->id, 'key_name' => '_recommended_product', 'key_value' => rand(0, 1)],
            ['product_id' => $product->id, 'key_name' => '_featured_product', 'key_value' => rand(0, 1)],
            ['product_id' => $product->id, 'key_name' => '_latest_product', 'key_value' => rand(0, 1)],
            ['product_id' => $product->id, 'key_name' => '_related_product', 'key_value' => rand(0, 1)],
            ['product_id' => $product->id, 'key_name' => '_home_page_product', 'key_value' => rand(0, 1)],
        ]);
    }

    public function runVariationExtraSeeder($product)
    {
        $attributeData = Term::activeAttributes()->inRandomOrder()->take(rand(1,3))->get();

        $attributeData = [];

        foreach ($attributeData as $data) {
            $attributeValue = $data->getExtraByKeyName('_attribute_values');
            $attributeValue = explode(',', $attributeValue);
            $attributeValue = $attributeValue[0] ?? null;
            $attributeData[] = $data->id . ':' . $attributeValue;
        }

        $attributeIds = TermRelationshipService::prepareAttributeIds($attributeData);
        TermRelationship::insert( TermRelationshipService::prepareData($attributeIds, $product->id, config('term-objects.product')) );
    }
}
