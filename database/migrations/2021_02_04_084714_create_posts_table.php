<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_author_id')->constrained('users');
            $table->string('post_title');
            $table->string('post_slug');
            $table->longText('post_content')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('posts')->onDelete('set null');
            $table->string('post_status');
            $table->string('post_type');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
