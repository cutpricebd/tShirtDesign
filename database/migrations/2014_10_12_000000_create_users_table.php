<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1); // 1- Active, 2- Pending, 0- Suspended
            $table->boolean('admin_read')->default(2);
            $table->string('type', 55)->default('customer'); // customer, admin, user
            $table->string('first_name')->nullable();
            $table->string('last_name');
            $table->string('designation')->nullable();
            $table->string('company_name')->nullable();
            $table->string('username', 191)->nullable()->unique();
            $table->string('mobile_number', 191)->nullable()->unique()->nullable();
            $table->string('email', 191)->unique()->nullable();
            $table->string('street')->nullable();
            $table->string('apartment')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('profile')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('bio')->nullable();
            $table->string('gander', 55)->nullable();
            $table->longText('address')->nullable(); // Json data
            $table->timestamp('order_submitted_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
