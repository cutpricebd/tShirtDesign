<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Addition, Subtraction
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_data_id');
            $table->integer('quantity');
            $table->integer('previous_quantity'); // Product Data Stock
            $table->integer('current_quantity'); // Product Data Stock
            $table->double('purchase_sale_price');
            $table->text('note')->nullable();
            $table->string('added_by')->nullable();
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
        Schema::dropIfExists('stock_histories');
    }
}
