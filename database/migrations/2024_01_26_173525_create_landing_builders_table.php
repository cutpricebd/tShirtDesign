<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_builders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('products_id'); // Json Data
            $table->string('theme')->default('default');
            $table->longText('data')->nullable();
            $table->bigInteger('views')->default(0);
            $table->text('head_code')->nullable();
            $table->text('body_code')->nullable();
            $table->text('footer_code')->nullable();
            $table->string('server_track')->nullable();
            $table->string('pixel_id')->nullable();
            $table->string('pixel_access_token')->nullable();
            $table->string('type')->default('Type 1'); // Type 1, Type 2
            $table->longText('others')->nullable(); // Json Data
            $table->unsignedBigInteger('product_id');
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
        Schema::dropIfExists('landing_builders');
    }
};
