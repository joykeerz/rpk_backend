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
        Schema::create('pos_promos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id');
            $table->string('promo_name');
            $table->string('promo_type');
            $table->string('promo_category');
            $table->double('promo_value');
            $table->dateTime('promo_start');
            $table->dateTime('promo_end');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_from_bulog')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_promos');
    }
};
