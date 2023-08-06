<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('parent_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('title');
            $table->string('slug');
            $table->longtext('content')->nullable();
            $table->string('sku', 60)->nullable();
            $table->float('regular_price')->nullable();
            $table->float('sale_price')->nullable();
            $table->float('price')->nullable();
            $table->integer('stock_qty')->unsigned()->nullable();
            $table->string('stock_availability', 30)->nullable();
            $table->string('status')->nullable();
            $table->string('type', 60)->nullable();
            $table->foreignId('image_id')->nullable()->constrained('media')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
