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
            $table->string('promo_name');
            $table->string('promo_type');
            $table->string('promo_category');
            $table->double('promo_value');
            $table->dateTime('promo_start');
            $table->dateTime('promo_end');
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
