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
        Schema::create('pos_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id');
            $table->string('discount_name');
            $table->string('discount_type');
            $table->double('discount_value');
            $table->boolean('is_from_bulog')->default(false);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_discounts');
    }
};
