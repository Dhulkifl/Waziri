<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fees_items', function (Blueprint $table) {
            $table->id();
            $table->integer('fee_id');
            $table->string('fee_type');
            $table->integer('fee_amount');
            $table->integer('discount');
            $table->integer('paid');
            $table->string('month');
            $table->string('year');
            $table->string('payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_items');
    }
};
