<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_data_id');
            $table->unsignedBigInteger('user_id')->nullable(); // Supplier
            $table->integer('purchase_quantity');
            $table->integer('current_quantity');
            $table->double('purchase_price');
            $table->text('note')->nullable();
            $table->foreignId('adjustment_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('stocks');
    }
}
