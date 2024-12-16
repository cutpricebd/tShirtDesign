<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1);
            $table->boolean('feature')->default(0);
            $table->integer('feature_position')->default(1000);
            $table->string('for', 55)->default('product'); // product, blog
            $table->string('title');
            $table->string("slug", 300);
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('position')->nullable()->default(1000);
            $table->boolean('featured')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_tags')->nullable();
            $table->string('banner_image')->nullable();
            $table->unsignedBigInteger('banner_image_id')->nullable();
            $table->string('feature_image')->nullable();
            $table->unsignedBigInteger('feature_image_id')->nullable();
            $table->boolean('collection')->default(0);
            $table->string('collection_image')->nullable();
            $table->unsignedBigInteger('collection_image_id')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->string('background_color')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
