<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_quotes', function (Blueprint $table) {
            $table->id();
            $table->string('status', 55)->default('Pending'); // Pending
            $table->boolean('admin_read')->default(2);
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->integer('quantity');
            $table->text('address')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('product_quotes');
    }
}
