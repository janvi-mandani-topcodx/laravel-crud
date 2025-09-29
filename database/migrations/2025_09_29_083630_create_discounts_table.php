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
            $table->string('minimum_requirements');
            $table->string('minimum_amount');
            $table->string('customer');
            $table->integer('user_id');
            $table->string('product');
            $table->integer('product_id');
            $table->string('discount_apply_type');
            $table->string('discount_type_number');
            $table->date('start_date');
            $table->date('end_date');
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
