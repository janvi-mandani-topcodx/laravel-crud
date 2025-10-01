<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('amount');
            $table->string('type');
            $table->string('minimum_requirements')->nullable();
            $table->string('minimum_amount')->nullable();
            $table->string('customer_eligibility')->nullable();
            $table->foreignId('customer_id')->nullable()->references('id')->on('users');
            $table->string('applies_product')->nullable();
            $table->foreignId('product_id')->nullable()->references('id')->on('products');
            $table->boolean('usage_limit_number_of_times_use')->nullable();
            $table->integer('usage_limit_number')->nullable();
            $table->boolean('usage_limit_one_user_per_customer')->nullable();
            $table->boolean('usage_limit_new_customer')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
