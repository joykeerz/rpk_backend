<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.s
     */
    public function up(): void
    {
        Schema::create('stok_etalase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_id');
            $table->integer('jumlah_stok');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_etalases');
    }
};
